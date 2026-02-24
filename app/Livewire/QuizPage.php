<?php

namespace App\Livewire;

use App\Models\QuizQuestion;
use App\Models\Broker;
use Livewire\Component;

class QuizPage extends Component
{
    public $currentQuestion = 0;
    public $answers = [];
    public $submitted = false;
    public $results = [];
    public $questions = [];
    public $totalQuestions = 0;
    public $embedded = false;

    public function mount($embedded = false)
    {
        $this->embedded = (bool) $embedded;
        $this->questions = QuizQuestion::where('is_active', true)
            ->orderBy('order')
            ->with('answers')
            ->get();
        $this->totalQuestions = count($this->questions);
    }

    public function selectAnswer($answerId)
    {
        if ($answerId === null || $answerId === '') {
            unset($this->answers[$this->currentQuestion]);
            return;
        }

        $this->answers[$this->currentQuestion] = (int) $answerId;
    }

    public function getLiveResults()
    {
        if (count($this->answers) === 0) {
            return [];
        }

        $brokerScores = [];

        foreach (Broker::where('is_active', true)->get() as $broker) {
            $score = 0;
            $matchedAnswers = 0;

            foreach ($this->answers as $answerId) {
                $match = $broker->matches()
                    ->where('quiz_answer_id', $answerId)
                    ->first();

                if ($match) {
                    $score += $match->weight;
                    $matchedAnswers++;
                }
            }

            // Only include brokers that match ALL answered questions
            if ($matchedAnswers === count($this->answers)) {
                $brokerScores[$broker->id] = [
                    'broker' => $broker,
                    'score' => $score,
                ];
            }
        }

        // Sort by score descending
        usort($brokerScores, fn($a, $b) => $b['score'] <=> $a['score']);

        return array_slice($brokerScores, 0, 3); // Top 3 brokers
    }

    public function nextQuestion()
    {
        if (!array_key_exists($this->currentQuestion, $this->answers)) {
            return;
        }

        if ($this->currentQuestion < $this->totalQuestions - 1) {
            $this->currentQuestion++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestion > 0) {
            $this->currentQuestion--;
        }
    }

    public function submitQuiz()
    {
        if (!array_key_exists($this->currentQuestion, $this->answers)) {
            return;
        }

        // Calculate broker scores - only include brokers matching ALL answers
        $brokerScores = [];

        foreach (Broker::where('is_active', true)->get() as $broker) {
            $score = 0;
            $matchedAnswers = 0;

            foreach ($this->answers as $answerId) {
                $match = $broker->matches()
                    ->where('quiz_answer_id', $answerId)
                    ->first();

                if ($match) {
                    $score += $match->weight;
                    $matchedAnswers++;
                }
            }

            // Only include brokers that match ALL answered questions
            if ($matchedAnswers === count($this->answers)) {
                $brokerScores[$broker->id] = [
                    'broker' => $broker,
                    'score' => $score,
                ];
            }
        }

        // Sort by score descending
        usort($brokerScores, fn($a, $b) => $b['score'] <=> $a['score']);

        $this->results = $brokerScores;

        $this->submitted = true;
    }

    public function resetQuiz()
    {
        $this->currentQuestion = 0;
        $this->answers = [];
        $this->submitted = false;
        $this->results = [];
    }

    public function render()
    {
        return view('livewire.quiz-page')
            ->layout('components.layouts.app');
    }
}
