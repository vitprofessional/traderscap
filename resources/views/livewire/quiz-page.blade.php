<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Top Menu Bar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition-colors">TradersCap</a>
            <div class="space-x-4">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a>
                @auth
                    <a href="{{ url('/admin') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Admin Panel</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Find My Best Broker</h1>
                <p class="text-gray-600 mb-8">Discover the perfect forex broker for your trading needs</p>

            @if (!$submitted)
                @if ($totalQuestions > 0)
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Question {{ $currentQuestion + 1 }} of {{ $totalQuestions }}</span>
                            <span class="text-sm font-medium text-indigo-600">{{ round(($currentQuestion + 1) / $totalQuestions * 100) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: {{ ($currentQuestion + 1) / $totalQuestions * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Question -->
                    @php
                        $question = $questions[$currentQuestion];
                        $selectedAnswer = $answers[$currentQuestion] ?? null;
                    @endphp

                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ $question->title }}</h2>
                        @if ($question->description)
                            <p class="text-gray-600 mb-4">{{ $question->description }}</p>
                        @endif

                        <!-- Answers -->
                        @if (count($question->answers) > 5)
                            <!-- Dropdown for more than 5 answers -->
                            <div class="mb-4">
                                <select 
                                    wire:model.live="answers.{{ $currentQuestion }}"
                                    class="w-full p-4 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none text-base"
                                >
                                    <option value="">Select an answer...</option>
                                    @foreach ($question->answers as $answer)
                                        <option value="{{ $answer->id }}">
                                            {{ $answer->text }}@if($answer->description) - {{ $answer->description }}@endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <!-- Radio buttons for 5 or fewer answers -->
                            <div class="space-y-3">
                                @forelse ($question->answers as $answer)
                                    <div wire:click="selectAnswer({{ $answer->id }})" class="w-full text-left flex items-center p-4 border-2 rounded-lg cursor-pointer transition-colors {{ isset($answers[$currentQuestion]) && $answers[$currentQuestion] === $answer->id ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 hover:border-gray-300' }}">
                                        <input type="radio" name="answer" value="{{ $answer->id }}"
                                            {{ isset($answers[$currentQuestion]) && $answers[$currentQuestion] === $answer->id ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 cursor-pointer pointer-events-none">
                                        <div class="ml-4 flex-1">
                                            <p class="font-medium text-gray-900">{{ $answer->text }}</p>
                                            @if ($answer->description)
                                                <p class="text-sm text-gray-500">{{ $answer->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-red-600">No answers loaded for this question</p>
                                @endforelse
                            </div>
                        @endif
                    </div>

                    <!-- Live Broker Recommendations -->
                    @php
                        $liveResults = $this->getLiveResults();
                    @endphp

                    @if (count($liveResults) > 0)
                        <div class="mb-8 p-6 bg-blue-50 border-2 border-blue-200 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Top Matching Brokers So Far</h3>
                            <div class="space-y-3">
                                @foreach ($liveResults as $index => $result)
                                    @php
                                        $broker = $result['broker'];
                                        $score = $result['score'];
                                    @endphp
                                    <div class="bg-white rounded-lg p-3 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg font-bold text-indigo-600">#{{ $index + 1 }}</span>
                                            @if ($broker->logo)
                                                <img src="{{ asset('storage/app/public/' . $broker->logo) }}" alt="{{ $broker->name }}" class="h-12 w-12 object-contain rounded" onerror="this.style.display='none'">
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $broker->name }}</p>
                                                @if ($broker->regulation)
                                                    <p class="text-xs text-gray-500">{{ $broker->regulation }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-600">Score</div>
                                            <div class="text-lg font-bold text-indigo-600">{{ $score }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-3">💡 Recommendations update as you answer more questions</p>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between gap-4">
                        <button wire:click="previousQuestion"
                            {{ $currentQuestion === 0 ? 'disabled' : '' }}
                            class="px-6 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            ← Previous
                        </button>

                        @if ($currentQuestion < $totalQuestions - 1)
                            <button wire:click="nextQuestion"
                                {{ !isset($answers[$currentQuestion]) ? 'disabled' : '' }}
                                class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                Next →
                            </button>
                        @else
                            <button wire:click="submitQuiz"
                                {{ !isset($answers[$currentQuestion]) ? 'disabled' : '' }}
                                class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                Find My Brokers →
                            </button>
                        @endif
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-xl text-gray-600">No quiz questions available at the moment.</p>
                    </div>
                @endif
            @else
                <!-- Results -->
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Your Recommended Brokers</h2>

                    @if (count($results) > 0)
                        <div class="space-y-4">
                            @foreach ($results as $index => $result)
                                @php
                                    $broker = $result['broker'];
                                    $score = $result['score'];
                                    $maxScore = $totalQuestions * 10; // Assuming max weight of 10 per answer
                                    $matchPercentage = min(round($score / $maxScore * 100), 100);
                                @endphp

                                <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-indigo-600 transition-colors">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-2xl font-bold text-indigo-600">#{{ $index + 1 }}</span>
                                                @if ($broker->logo)
                                                <img src="{{ asset('storage/app/public/' . $broker->logo) }}" alt="{{ $broker->name }}" class="h-12 w-12 object-contain rounded" onerror="this.style.display='none'">
                                                @endif
                                                <h3 class="text-xl font-semibold text-gray-900">{{ $broker->name }}</h3>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                @if ($broker->rating)
                                                    <span class="inline-flex items-center gap-1 text-yellow-500">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i < floor($broker->rating) ? 'fill-current' : 'fill-gray-300' }}" viewBox="0 0 20 20">
                                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                            </svg>
                                                        @endfor
                                                    </span>
                                                    <span class="text-sm text-gray-600">{{ $broker->rating }}/5</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-600 mb-1">Match Score</div>
                                            <div class="text-3xl font-bold text-indigo-600">{{ $matchPercentage }}%</div>
                                        </div>
                                    </div>

                                    @if ($broker->description)
                                        <p class="text-gray-700 mb-4">{{ $broker->description }}</p>
                                    @endif

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        @if ($broker->min_deposit)
                                            <div>
                                                <p class="text-sm text-gray-600">Min. Deposit</p>
                                                <p class="text-lg font-semibold text-gray-900">{{ $broker->min_deposit }}</p>
                                            </div>
                                        @endif
                                        @if ($broker->regulation)
                                            <div>
                                                <p class="text-sm text-gray-600">Regulation</p>
                                                <p class="text-lg font-semibold text-gray-900">{{ $broker->regulation }}</p>
                                            </div>
                                        @endif
                                        @if ($broker->years_in_business)
                                            <div>
                                                <p class="text-sm text-gray-600">Years in Business</p>
                                                <p class="text-lg font-semibold text-gray-900">{{ $broker->years_in_business }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if (is_array($broker->pros) && count($broker->pros) > 0 || is_array($broker->cons) && count($broker->cons) > 0)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            @if (is_array($broker->pros) && count($broker->pros) > 0)
                                                <div>
                                                    <p class="text-sm font-semibold text-green-700 mb-2">Pros:</p>
                                                    <ul class="text-sm text-gray-700 space-y-1">
                                                        @foreach ($broker->pros as $pro)
                                                            <li class="flex items-start gap-2">
                                                                <span class="text-green-600 font-bold">✓</span>
                                                                <span>{{ $pro }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            @if (is_array($broker->cons) && count($broker->cons) > 0)
                                                <div>
                                                    <p class="text-sm font-semibold text-red-700 mb-2">Cons:</p>
                                                    <ul class="text-sm text-gray-700 space-y-1">
                                                        @foreach ($broker->cons as $con)
                                                            <li class="flex items-start gap-2">
                                                                <span class="text-red-600 font-bold">✗</span>
                                                                <span>{{ $con }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if ($broker->website)
                                        <a href="{{ $broker->website }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-block px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                            Visit Website →
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-blue-50 rounded-lg">
                            <p class="text-xl text-gray-700 mb-4">No matching brokers found for your preferences.</p>
                            <button wire:click="resetQuiz" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                Try Again
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Reset Button -->
                <div class="flex justify-center">
                    <button wire:click="resetQuiz"
                        class="px-6 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                        Start Over
                    </button>
                </div>
            @endif
        </div>
    </div>
    </div>
</div>
