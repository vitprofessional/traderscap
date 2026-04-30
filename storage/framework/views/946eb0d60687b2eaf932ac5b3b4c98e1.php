<?php
    $isEmbedded = $embedded ?? false;
?>

<div class="<?php echo e($isEmbedded ? '' : 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100'); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isEmbedded): ?>
    <!-- Top Menu Bar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?php echo e(url('/')); ?>" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition-colors">TradersCap</a>
            <div class="space-x-4">
                <a href="<?php echo e(url('/')); ?>" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" class="text-gray-600 hover:text-gray-900 transition-colors">Customer Panel</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </nav>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="<?php echo e($isEmbedded ? '' : 'py-12 px-4'); ?>">
        <div class="<?php echo e($isEmbedded ? '' : 'max-w-4xl mx-auto'); ?>">
            <div class="bg-white rounded-lg shadow-xl p-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Find My Best Broker</h1>
                <p class="text-gray-600 mb-8">Discover the perfect forex broker for your trading needs</p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$submitted): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalQuestions > 0): ?>
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Question <?php echo e($currentQuestion + 1); ?> of <?php echo e($totalQuestions); ?></span>
                            <span class="text-sm font-medium text-indigo-600"><?php echo e(round(($currentQuestion + 1) / $totalQuestions * 100)); ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: <?php echo e(($currentQuestion + 1) / $totalQuestions * 100); ?>%"></div>
                        </div>
                    </div>

                    <!-- Question -->
                    <?php
                        $question = $questions[$currentQuestion];
                        $selectedAnswer = $answers[$currentQuestion] ?? null;
                    ?>

                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6"><?php echo e($question->title); ?></h2>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($question->description): ?>
                            <p class="text-gray-600 mb-4"><?php echo e($question->description); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- Answers -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($question->answers) > 5): ?>
                            <!-- Dropdown for more than 5 answers -->
                            <div class="mb-4">
                                <select 
                                    wire:change="selectAnswer($event.target.value)"
                                    class="w-full p-4 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none text-base"
                                >
                                    <option value="">Select an answer...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($answer->id); ?>" <?php echo e((int) $selectedAnswer === (int) $answer->id ? 'selected' : ''); ?>>
                                            <?php echo e($answer->text); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($answer->description): ?> - <?php echo e($answer->description); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <!-- Radio buttons for 5 or fewer answers -->
                            <div class="space-y-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <button type="button"
                                        wire:key="question-<?php echo e($question->id); ?>-answer-<?php echo e($answer->id); ?>"
                                        wire:click="selectAnswer(<?php echo e($answer->id); ?>)"
                                        class="w-full text-left flex items-center p-4 border-2 rounded-lg cursor-pointer transition-colors <?php echo e((int) $selectedAnswer === (int) $answer->id ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 hover:border-gray-300'); ?>">
                                        <input type="radio" name="answer" value="<?php echo e($answer->id); ?>"
                                            <?php echo e((int) $selectedAnswer === (int) $answer->id ? 'checked' : ''); ?>

                                            class="w-4 h-4 text-indigo-600 pointer-events-none">
                                        <div class="ml-4 flex-1">
                                            <p class="font-medium text-gray-900"><?php echo e($answer->text); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($answer->description): ?>
                                                <p class="text-sm text-gray-500"><?php echo e($answer->description); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-red-600">No answers loaded for this question</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Live Broker Recommendations -->
                    <?php
                        $liveResults = $this->getLiveResults();
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($liveResults) > 0): ?>
                        <div class="mb-8 p-6 bg-blue-50 border-2 border-blue-200 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Top Matching Brokers So Far</h3>
                            <div class="space-y-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $liveResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $broker = $result['broker'];
                                        $score = $result['score'];
                                    ?>
                                    <div class="bg-white rounded-lg p-3 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg font-bold text-indigo-600">#<?php echo e($index + 1); ?></span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->logo): ?>
                                                <img src="<?php echo e(asset('storage/app/public/' . $broker->logo)); ?>" alt="<?php echo e($broker->name); ?>" class="h-12 w-12 object-contain rounded" onerror="this.style.display='none'">
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo e($broker->name); ?></p>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->regulation): ?>
                                                    <p class="text-xs text-gray-500"><?php echo e($broker->regulation); ?></p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-600">Score</div>
                                            <div class="text-lg font-bold text-indigo-600"><?php echo e($score); ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">💡 Recommendations update as you answer more questions</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between gap-4">
                        <button wire:click="previousQuestion"
                            <?php echo e($currentQuestion === 0 ? 'disabled' : ''); ?>

                            class="px-6 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            ← Previous
                        </button>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentQuestion < $totalQuestions - 1): ?>
                            <button wire:click="nextQuestion"
                                <?php echo e(empty($selectedAnswer) ? 'disabled' : ''); ?>

                                class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                Next →
                            </button>
                        <?php else: ?>
                            <button wire:click="submitQuiz"
                                <?php echo e(empty($selectedAnswer) ? 'disabled' : ''); ?>

                                class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                Find My Brokers →
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <p class="text-xl text-gray-600">No quiz questions available at the moment.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php else: ?>
                <!-- Results -->
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Your Recommended Brokers</h2>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($results) > 0): ?>
                        <div class="space-y-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $broker = $result['broker'];
                                    $score = $result['score'];
                                    $maxScore = $totalQuestions * 10; // Assuming max weight of 10 per answer
                                    $matchPercentage = min(round($score / $maxScore * 100), 100);
                                ?>

                                <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-indigo-600 transition-colors">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-2xl font-bold text-indigo-600">#<?php echo e($index + 1); ?></span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->logo): ?>
                                                <img src="<?php echo e(asset('storage/app/public/' . $broker->logo)); ?>" alt="<?php echo e($broker->name); ?>" class="h-12 w-12 object-contain rounded" onerror="this.style.display='none'">
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <h3 class="text-xl font-semibold text-gray-900"><?php echo e($broker->name); ?></h3>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->rating): ?>
                                                    <span class="inline-flex items-center gap-1 text-yellow-500">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?>
                                                            <svg class="w-4 h-4 <?php echo e($i < floor($broker->rating) ? 'fill-current' : 'fill-gray-300'); ?>" viewBox="0 0 20 20">
                                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                            </svg>
                                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </span>
                                                    <span class="text-sm text-gray-600"><?php echo e($broker->rating); ?>/5</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-600 mb-1">Match Score</div>
                                            <div class="text-3xl font-bold text-indigo-600"><?php echo e($matchPercentage); ?>%</div>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->description): ?>
                                        <p class="text-gray-700 mb-4"><?php echo e($broker->description); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->min_deposit): ?>
                                            <div>
                                                <p class="text-sm text-gray-600">Min. Deposit</p>
                                                <p class="text-lg font-semibold text-gray-900"><?php echo e($broker->min_deposit); ?></p>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->regulation): ?>
                                            <div>
                                                <p class="text-sm text-gray-600">Regulation</p>
                                                <p class="text-lg font-semibold text-gray-900"><?php echo e($broker->regulation); ?></p>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->years_in_business): ?>
                                            <div>
                                                <p class="text-sm text-gray-600">Years in Business</p>
                                                <p class="text-lg font-semibold text-gray-900"><?php echo e($broker->years_in_business); ?></p>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($broker->pros) && count($broker->pros) > 0 || is_array($broker->cons) && count($broker->cons) > 0): ?>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <?php if(is_array($broker->pros) && count($broker->pros) > 0): ?>
                                                <div>
                                                    <p class="text-sm font-semibold text-green-700 mb-2">Pros:</p>
                                                    <ul class="text-sm text-gray-700 space-y-1">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $broker->pros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="flex items-start gap-2">
                                                                <span class="text-green-600 font-bold">✓</span>
                                                                <span><?php echo e($pro); ?></span>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($broker->cons) && count($broker->cons) > 0): ?>
                                                <div>
                                                    <p class="text-sm font-semibold text-red-700 mb-2">Cons:</p>
                                                    <ul class="text-sm text-gray-700 space-y-1">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $broker->cons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="flex items-start gap-2">
                                                                <span class="text-red-600 font-bold">✗</span>
                                                                <span><?php echo e($con); ?></span>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->website): ?>
                                        <a href="<?php echo e($broker->website); ?>" target="_blank" rel="noopener noreferrer"
                                            class="inline-block px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                            Visit Website →
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12 bg-blue-50 rounded-lg">
                            <p class="text-xl text-gray-700 mb-4">No matching brokers found for your preferences.</p>
                            <button wire:click="resetQuiz" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                Try Again
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Reset Button -->
                <div class="flex justify-center">
                    <button wire:click="resetQuiz"
                        class="px-6 py-2 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                        Start Over
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/livewire/quiz-page.blade.php ENDPATH**/ ?>