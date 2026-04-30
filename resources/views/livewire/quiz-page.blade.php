@php
    $isEmbedded = $embedded ?? false;
    $questionNumber = ($currentQuestion ?? 0) + 1;
    $progress = $totalQuestions > 0 ? round(($questionNumber / $totalQuestions) * 100) : 0;
@endphp

<div class="quiz-shell {{ $isEmbedded ? 'quiz-shell--embedded' : '' }}">
    <style>
        .quiz-shell {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(251, 191, 36, 0.18), transparent 24%),
                radial-gradient(circle at right top, rgba(59, 130, 246, 0.12), transparent 20%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            color: #0f172a;
        }

        .quiz-shell--embedded {
            min-height: auto;
            background: transparent;
        }

        .quiz-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: rgba(15, 23, 42, 0.96);
            color: #fff;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.16);
        }

        .quiz-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #fff;
            text-decoration: none;
        }

        .quiz-brand__mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.85rem;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #0f172a;
            box-shadow: 0 10px 20px rgba(251, 191, 36, 0.22);
        }

        .quiz-topbar__links {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .quiz-topbar__link {
            color: rgba(226, 232, 240, 0.82);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 150ms ease;
        }

        .quiz-topbar__link:hover {
            color: #fff;
        }

        .quiz-viewport {
            max-width: 1180px;
            margin: 0 auto;
            padding: 1.5rem 1rem 2rem;
        }

        .quiz-hero {
            display: grid;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .quiz-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: fit-content;
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.8);
            padding: 0.45rem 0.8rem;
            font-size: 0.85rem;
            color: #475569;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.04);
        }

        .quiz-hero__eyebrow-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 999px;
            background: #fbbf24;
        }

        .quiz-hero__title {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: #0f172a;
        }

        .quiz-hero__subtitle {
            max-width: 52rem;
            margin: 0;
            font-size: 1rem;
            line-height: 1.7;
            color: #475569;
        }

        .quiz-grid {
            display: grid;
            gap: 1.25rem;
        }

        .quiz-panel,
        .quiz-summary,
        .quiz-results,
        .quiz-empty {
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 1.5rem;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(12px);
        }

        .quiz-panel {
            padding: 1.25rem;
        }

        .quiz-summary {
            padding: 1rem;
        }

        .quiz-panel__header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .quiz-panel__title {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: #0f172a;
        }

        .quiz-panel__text {
            margin: 0.35rem 0 0;
            font-size: 0.92rem;
            line-height: 1.6;
            color: #64748b;
        }

        .quiz-step {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            background: #eff6ff;
            padding: 0.45rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #1d4ed8;
        }

        .quiz-progress {
            margin: 1rem 0 1.5rem;
        }

        .quiz-progress__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.55rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
        }

        .quiz-progress__bar {
            height: 0.75rem;
            overflow: hidden;
            border-radius: 999px;
            background: #e2e8f0;
        }

        .quiz-progress__fill {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 45%, #2563eb 100%);
            transition: width 220ms ease;
        }

        .quiz-question {
            margin-bottom: 1.25rem;
        }

        .quiz-question__title {
            margin: 0 0 0.6rem;
            font-size: clamp(1.4rem, 2vw, 1.9rem);
            line-height: 1.2;
            font-weight: 700;
            color: #0f172a;
        }

        .quiz-question__description {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.7;
            color: #64748b;
        }

        .quiz-answer-list {
            display: grid;
            gap: 0.8rem;
        }

        .quiz-answer-card {
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
            width: 100%;
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 1.1rem;
            background: #fff;
            padding: 1rem 1.05rem;
            text-align: left;
            cursor: pointer;
            transition: transform 150ms ease, border-color 150ms ease, box-shadow 150ms ease, background-color 150ms ease;
        }

        .quiz-answer-card:hover {
            transform: translateY(-1px);
            border-color: rgba(251, 191, 36, 0.38);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
            background: rgba(255, 251, 235, 0.88);
        }

        .quiz-answer-card.is-selected {
            border-color: rgba(37, 99, 235, 0.45);
            background: linear-gradient(180deg, rgba(239, 246, 255, 0.9), rgba(255, 255, 255, 1));
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.08);
        }

        .quiz-answer-card__radio {
            margin-top: 0.15rem;
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
            accent-color: #1d4ed8;
        }

        .quiz-answer-card__body {
            min-width: 0;
            flex: 1;
        }

        .quiz-answer-card__title {
            margin: 0;
            font-size: 0.98rem;
            font-weight: 700;
            color: #0f172a;
        }

        .quiz-answer-card__description {
            margin: 0.3rem 0 0;
            font-size: 0.88rem;
            line-height: 1.6;
            color: #64748b;
        }

        .quiz-answer-select {
            width: 100%;
            border: 1px solid rgba(148, 163, 184, 0.28);
            border-radius: 1rem;
            background: #fff;
            padding: 0.95rem 1rem;
            font-size: 0.95rem;
            color: #0f172a;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.04);
        }

        .quiz-answer-select:focus {
            outline: none;
            border-color: rgba(37, 99, 235, 0.45);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
        }

        .quiz-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.35rem;
        }

        .quiz-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            border: 1px solid transparent;
            border-radius: 999px;
            padding: 0.85rem 1.15rem;
            font-size: 0.92rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform 150ms ease, box-shadow 150ms ease, background-color 150ms ease, opacity 150ms ease;
        }

        .quiz-button:hover {
            transform: translateY(-1px);
        }

        .quiz-button--ghost {
            background: #e2e8f0;
            color: #0f172a;
        }

        .quiz-button--primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            box-shadow: 0 14px 26px rgba(37, 99, 235, 0.18);
        }

        .quiz-button--success {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff;
            box-shadow: 0 14px 26px rgba(22, 163, 74, 0.18);
        }

        .quiz-button[disabled] {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
        }

        .quiz-aside {
            display: grid;
            gap: 1rem;
        }

        .quiz-summary__title,
        .quiz-results__title,
        .quiz-empty__title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
        }

        .quiz-summary__list,
        .quiz-results__list {
            display: grid;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .quiz-summary__item,
        .quiz-results__item {
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 1rem;
            background: #f8fafc;
            padding: 0.9rem 1rem;
        }

        .quiz-summary__item-top,
        .quiz-results__item-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .quiz-summary__item-label,
        .quiz-results__item-label {
            margin: 0;
            font-size: 0.9rem;
            color: #64748b;
        }

        .quiz-summary__item-value,
        .quiz-results__item-value {
            margin: 0.3rem 0 0;
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
        }

        .quiz-results__score {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1d4ed8;
        }

        .quiz-results__meta {
            margin: 0.45rem 0 0;
            font-size: 0.85rem;
            color: #64748b;
        }

        .quiz-results__details {
            display: grid;
            gap: 0.9rem;
            margin-top: 1rem;
        }

        .quiz-results__two-col {
            display: grid;
            gap: 1rem;
        }

        .quiz-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.9rem;
        }

        .quiz-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .quiz-badge--success {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        .quiz-badge--danger {
            background: rgba(244, 63, 94, 0.12);
            color: #be123c;
        }

        .quiz-empty {
            padding: 2rem;
            text-align: center;
        }

        .quiz-empty__text {
            margin: 0.5rem 0 0;
            color: #64748b;
        }

        .quiz-results__website {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
            border-radius: 999px;
            background: #2563eb;
            padding: 0.75rem 1rem;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
        }

        .quiz-results__website:hover {
            background: #1d4ed8;
        }

        @media (min-width: 1024px) {
            .quiz-grid {
                grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.65fr);
                align-items: start;
            }

            .quiz-results__two-col {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>

    <div class="{{ $isEmbedded ? '' : 'quiz-shell--page' }}">
        @if (! $isEmbedded)
            <nav class="quiz-topbar">
                <a href="{{ url('/') }}" class="quiz-brand">
                    <span class="quiz-brand__mark">TC</span>
                    <span>Traderscap</span>
                </a>
                <div class="quiz-topbar__links">
                    <a href="{{ url('/') }}" class="quiz-topbar__link">Home</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="quiz-topbar__link">Customer Panel</a>
                    @endauth
                </div>
            </nav>
        @endif

        <div class="quiz-viewport {{ $isEmbedded ? '' : 'quiz-viewport--page' }}">
            <section class="quiz-hero">
                <span class="quiz-hero__eyebrow"><span class="quiz-hero__eyebrow-dot"></span>Broker matching quiz</span>
                <h1 class="quiz-hero__title">Find the best broker for your trading profile</h1>
                <p class="quiz-hero__subtitle">
                    Answer a few structured questions and get a cleaner shortlist based on compatibility, regulation, and trading preferences.
                </p>
            </section>

            @if (! $submitted)
                @if ($totalQuestions > 0)
                    <div class="quiz-grid">
                        <section class="quiz-panel">
                            <div class="quiz-panel__header">
                                <div>
                                    <p class="quiz-step">Question {{ $questionNumber }} of {{ $totalQuestions }}</p>
                                    <h2 class="quiz-panel__title" style="margin-top:0.85rem;">Choose one answer that best fits you</h2>
                                    <p class="quiz-panel__text">Your selections update the match suggestions as you move through the quiz.</p>
                                </div>
                            </div>

                            <div class="quiz-progress">
                                <div class="quiz-progress__meta">
                                    <span>Progress</span>
                                    <span>{{ $progress }}%</span>
                                </div>
                                <div class="quiz-progress__bar">
                                    <div class="quiz-progress__fill" style="width: {{ $progress }}%;"></div>
                                </div>
                            </div>

                            @php
                                $question = $questions[$currentQuestion];
                                $selectedAnswer = $answers[$currentQuestion] ?? null;
                            @endphp

                            <div class="quiz-question">
                                <h3 class="quiz-question__title">{{ $question->title }}</h3>
                                @if ($question->description)
                                    <p class="quiz-question__description">{{ $question->description }}</p>
                                @endif
                            </div>

                            @if (count($question->answers) > 5)
                                <select
                                    wire:change="selectAnswer($event.target.value)"
                                    class="quiz-answer-select"
                                >
                                    <option value="">Select an answer...</option>
                                    @foreach ($question->answers as $answer)
                                        <option value="{{ $answer->id }}" {{ (int) $selectedAnswer === (int) $answer->id ? 'selected' : '' }}>
                                            {{ $answer->text }}@if ($answer->description) - {{ $answer->description }}@endif
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <div class="quiz-answer-list">
                                    @forelse ($question->answers as $answer)
                                        <button
                                            type="button"
                                            wire:key="question-{{ $question->id }}-answer-{{ $answer->id }}"
                                            wire:click="selectAnswer({{ $answer->id }})"
                                            class="quiz-answer-card {{ (int) $selectedAnswer === (int) $answer->id ? 'is-selected' : '' }}"
                                        >
                                            <input
                                                type="radio"
                                                name="answer"
                                                value="{{ $answer->id }}"
                                                {{ (int) $selectedAnswer === (int) $answer->id ? 'checked' : '' }}
                                                class="quiz-answer-card__radio"
                                            >
                                            <div class="quiz-answer-card__body">
                                                <p class="quiz-answer-card__title">{{ $answer->text }}</p>
                                                @if ($answer->description)
                                                    <p class="quiz-answer-card__description">{{ $answer->description }}</p>
                                                @endif
                                            </div>
                                        </button>
                                    @empty
                                        <div class="quiz-empty" style="padding:1rem;">
                                            <p class="quiz-empty__title">No answers loaded for this question</p>
                                        </div>
                                    @endforelse
                                </div>
                            @endif

                            <div class="quiz-actions">
                                <button
                                    wire:click="previousQuestion"
                                    {{ $currentQuestion === 0 ? 'disabled' : '' }}
                                    class="quiz-button quiz-button--ghost"
                                >
                                    Previous
                                </button>

                                @if ($currentQuestion < $totalQuestions - 1)
                                    <button
                                        wire:click="nextQuestion"
                                        {{ empty($selectedAnswer) ? 'disabled' : '' }}
                                        class="quiz-button quiz-button--primary"
                                    >
                                        Next question
                                    </button>
                                @else
                                    <button
                                        wire:click="submitQuiz"
                                        {{ empty($selectedAnswer) ? 'disabled' : '' }}
                                        class="quiz-button quiz-button--success"
                                    >
                                        Find my brokers
                                    </button>
                                @endif
                            </div>
                        </section>

                        <aside class="quiz-aside">
                            @php
                                $liveResults = $this->getLiveResults();
                            @endphp

                            <section class="quiz-summary">
                                <h3 class="quiz-summary__title">Live match preview</h3>
                                <div class="quiz-summary__list">
                                    <div class="quiz-summary__item">
                                        <div class="quiz-summary__item-top">
                                            <div>
                                                <p class="quiz-summary__item-label">Open tickets</p>
                                                <p class="quiz-summary__item-value">{{ count($liveResults) > 0 ? 'Updating' : 'Waiting for answers' }}</p>
                                            </div>
                                            <span class="quiz-badge quiz-badge--success">Live</span>
                                        </div>
                                    </div>
                                    <div class="quiz-summary__item">
                                        <div class="quiz-summary__item-top">
                                            <div>
                                                <p class="quiz-summary__item-label">Question focus</p>
                                                <p class="quiz-summary__item-value">{{ $question->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="quiz-results">
                                <h3 class="quiz-results__title">Top matching brokers so far</h3>
                                @if (count($liveResults) > 0)
                                    <div class="quiz-results__list">
                                        @foreach ($liveResults as $index => $result)
                                            @php
                                                $broker = $result['broker'];
                                                $score = $result['score'];
                                            @endphp
                                            <div class="quiz-results__item">
                                                <div class="quiz-results__item-top">
                                                    <div>
                                                        <p class="quiz-results__item-label">#{{ $index + 1 }} {{ $broker->name }}</p>
                                                        @if ($broker->regulation)
                                                            <p class="quiz-results__meta">{{ $broker->regulation }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="quiz-results__score">{{ $score }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="quiz-panel__text" style="margin-top:0.85rem;">Recommendations update as you answer more questions.</p>
                                @else
                                    <div class="quiz-empty" style="padding:1.25rem; margin-top:1rem;">
                                        <p class="quiz-empty__title" style="font-size:1rem;">No matches yet</p>
                                        <p class="quiz-empty__text">Select a few answers to see live broker suggestions here.</p>
                                    </div>
                                @endif
                            </section>
                        </aside>
                    </div>
                @else
                    <div class="quiz-empty">
                        <h2 class="quiz-empty__title">No quiz questions available at the moment.</h2>
                        <p class="quiz-empty__text">Please check back later when questions have been published.</p>
                    </div>
                @endif
            @else
                <div class="quiz-grid">
                    <section class="quiz-results" style="padding:1.25rem;">
                        <h2 class="quiz-results__title" style="font-size:1.5rem;">Your recommended brokers</h2>
                        <p class="quiz-panel__text">These brokers matched the preferences you selected in the quiz.</p>

                        @if (count($results) > 0)
                            <div class="quiz-results__list" style="margin-top:1.25rem;">
                                @foreach ($results as $index => $result)
                                    @php
                                        $broker = $result['broker'];
                                        $score = $result['score'];
                                        $maxScore = max($totalQuestions * 10, 1);
                                        $matchPercentage = min(round(($score / $maxScore) * 100), 100);
                                    @endphp

                                    <article class="quiz-panel" style="padding:1.1rem; margin:0;">
                                        <div class="quiz-results__item-top">
                                            <div>
                                                <p class="quiz-results__item-label">Recommendation #{{ $index + 1 }}</p>
                                                <h3 class="quiz-results__item-value" style="font-size:1.25rem;">{{ $broker->name }}</h3>
                                                @if ($broker->regulation)
                                                    <p class="quiz-results__meta">{{ $broker->regulation }}</p>
                                                @endif
                                            </div>
                                            <div style="text-align:right;">
                                                <p class="quiz-results__item-label">Match score</p>
                                                <div class="quiz-results__score" style="font-size:1.4rem;">{{ $matchPercentage }}%</div>
                                            </div>
                                        </div>

                                        @if ($broker->description)
                                            <p class="quiz-panel__text" style="margin-top:0.85rem;">{{ $broker->description }}</p>
                                        @endif

                                        <div class="quiz-results__two-col" style="margin-top:1rem;">
                                            @if ($broker->min_deposit)
                                                <div class="quiz-summary__item">
                                                    <p class="quiz-summary__item-label">Min. deposit</p>
                                                    <p class="quiz-summary__item-value">{{ $broker->min_deposit }}</p>
                                                </div>
                                            @endif
                                            @if ($broker->years_in_business)
                                                <div class="quiz-summary__item">
                                                    <p class="quiz-summary__item-label">Years in business</p>
                                                    <p class="quiz-summary__item-value">{{ $broker->years_in_business }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="quiz-badges">
                                            <span class="quiz-badge quiz-badge--success">High match</span>
                                            <span class="quiz-badge quiz-badge--danger">Review fees</span>
                                        </div>

                                        @if ($broker->website)
                                            <a href="{{ $broker->website }}" target="_blank" rel="noopener noreferrer" class="quiz-results__website">Visit website</a>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="quiz-empty" style="margin-top:1rem;">
                                <h3 class="quiz-empty__title">No matching brokers found</h3>
                                <p class="quiz-empty__text">Try again with different answers to broaden the match results.</p>
                            </div>
                        @endif
                    </section>

                    <aside class="quiz-aside">
                        <section class="quiz-summary">
                            <h3 class="quiz-summary__title">What happens next</h3>
                            <div class="quiz-summary__list">
                                <div class="quiz-summary__item">
                                    <p class="quiz-summary__item-label">Step 1</p>
                                    <p class="quiz-summary__item-value">Review your top matches</p>
                                </div>
                                <div class="quiz-summary__item">
                                    <p class="quiz-summary__item-label">Step 2</p>
                                    <p class="quiz-summary__item-value">Compare regulation and deposit levels</p>
                                </div>
                                <div class="quiz-summary__item">
                                    <p class="quiz-summary__item-label">Step 3</p>
                                    <p class="quiz-summary__item-value">Open the broker website</p>
                                </div>
                            </div>
                        </section>

                        <div class="quiz-actions" style="justify-content:flex-start;">
                            <button wire:click="resetQuiz" class="quiz-button quiz-button--ghost">Start over</button>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </div>
</div>
