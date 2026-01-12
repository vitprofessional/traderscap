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

    public function mount()
    {
        $this->questions = QuizQuestion::where('is_active', true)
            ->orderBy('order')
            ->with('answers')
            ->get();
        $this->totalQuestions = count($this->questions);
    }

    public function selectAnswer($answerId)
    {
        $this->answers[$this->currentQuestion] = $answerId;
    }

    public function getLiveResults()
    {
        if (count($this->answers) === 0) {
            return [];
        }

        $brokerScores = [];

        foreach (Broker::where('is_active', true)->get() as $broker) {
            $score = 0;
            foreach ($this->answers as $answerId) {
                $match = $broker->matches()
                    ->where('quiz_answer_id', $answerId)
                    ->first();

                if ($match) {
                    $score += $match->weight;
                }
            }
            if ($score > 0) {
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
        // Calculate broker scores
        $brokerScores = [];

        foreach (Broker::where('is_active', true)->get() as $broker) {
            $score = 0;
            foreach ($this->answers as $answerId) {
                $match = $broker->matches()
                    ->where('quiz_answer_id', $answerId)
                    ->first();

                if ($match) {
                    $score += $match->weight;
                }
            }
            if ($score > 0) {
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
        return view('livewire.quiz-page');
    }
}
