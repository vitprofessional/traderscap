<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Models\QuizQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrokerFinderApiController extends Controller
{
    public function questions(): JsonResponse
    {
        $questions = QuizQuestion::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->with(['answers' => function ($query) {
                $query->orderBy('order');
            }])
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->title,
                    'description' => $question->description,
                    'order' => $question->order,
                    'answers' => $question->answers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'text' => $answer->text,
                            'description' => $answer->description,
                            'order' => $answer->order,
                        ];
                    })->values(),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }

    public function match(Request $request): JsonResponse
    {
        $data = $request->validate([
            'answers' => ['required', 'array', 'min:1'],
            'answers.*' => ['integer', 'exists:quiz_answers,id'],
        ]);

        $answerIds = collect($data['answers'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $brokerScores = [];

        foreach (Broker::query()->where('is_active', true)->get() as $broker) {
            $score = 0;
            $matchedAnswers = 0;

            foreach ($answerIds as $answerId) {
                $match = $broker->matches()
                    ->where('quiz_answer_id', $answerId)
                    ->first();

                if ($match) {
                    $score += (int) $match->weight;
                    $matchedAnswers++;
                }
            }

            if ($matchedAnswers === $answerIds->count()) {
                $brokerScores[] = [
                    'id' => $broker->id,
                    'name' => $broker->name,
                    'description' => $broker->description,
                    'short_description' => $broker->description,
                    'website' => $broker->website,
                    'url' => $broker->website,
                    'logo' => $this->logoUrl($broker->logo),
                    'min_deposit' => $broker->min_deposit,
                    'regulation' => $broker->regulation,
                    'years_in_business' => $broker->years_in_business,
                    'features' => $this->normalizeJsonField($broker->features),
                    'pros' => $this->normalizeJsonField($broker->pros),
                    'cons' => $this->normalizeJsonField($broker->cons),
                    'rating' => $broker->rating,
                    'score' => $score,
                ];
            }
        }

        usort($brokerScores, fn ($a, $b) => $b['score'] <=> $a['score']);

        return response()->json([
            'success' => true,
            'results' => array_values($brokerScores),
            'top_results' => array_slice(array_values($brokerScores), 0, 3),
            'total' => count($brokerScores),
        ]);
    }

    public function recommendations(): JsonResponse
    {
        $brokers = Broker::query()
            ->where('is_active', true)
            ->orderByDesc('rating')
            ->orderByDesc('years_in_business')
            ->get()
            ->map(function ($broker) {
                return [
                    'id' => $broker->id,
                    'name' => $broker->name,
                    'description' => $broker->description,
                    'short_description' => $broker->description,
                    'website' => $broker->website,
                    'url' => $broker->website,
                    'logo' => $this->logoUrl($broker->logo),
                    'min_deposit' => is_numeric($broker->min_deposit) ? number_format((float) $broker->min_deposit, 2, '.', '') : null,
                    'rating' => is_numeric($broker->rating) ? number_format((float) $broker->rating, 1, '.', '') : null,
                    'regulation' => $broker->regulation,
                    'years_in_business' => $broker->years_in_business,
                    'features' => $this->normalizeJsonField($broker->features),
                    'pros' => $this->normalizeJsonField($broker->pros),
                    'cons' => $this->normalizeJsonField($broker->cons),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $brokers,
        ]);
    }

    private function logoUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

            $normalizedPath = preg_replace('#^(storage/app/public|public/storage|public|storage)/#', '', $path);

            return Storage::disk('public')->url(ltrim($normalizedPath, '/'));
    }

    private function normalizeJsonField($value): array
    {
        if (is_array($value)) {
            return array_values(array_filter($value, fn ($item) => filled($item)));
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_values(array_filter($decoded, fn ($item) => filled($item)));
            }
        }

        return [];
    }
}