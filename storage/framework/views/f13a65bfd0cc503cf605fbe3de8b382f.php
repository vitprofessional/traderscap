<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brokers->isEmpty()): ?>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center">
            <p class="text-gray-600 text-lg">No brokers available at the moment.</p>
        </div>
    <?php else: ?>
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <!-- Table Header -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Rank</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Broker Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Rating</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Min. Deposit</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Regulation</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Experience</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $brokers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $broker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Rank -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full <?php echo e($index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-100 text-gray-800' : ($index === 2 ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800'))); ?> font-bold text-sm">
                                        #<?php echo e($index + 1); ?>

                                    </div>
                                </td>

                                <!-- Broker Name with Logo -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->logo): ?>
                                            <img src="<?php echo e(asset('storage/app/public/' . $broker->logo)); ?>" alt="<?php echo e($broker->name); ?>" class="h-10 w-10 object-contain rounded" onerror="this.style.display='none'">
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div>
                                            <p class="font-semibold text-gray-900"><?php echo e($broker->name); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->description): ?>
                                                <p class="text-xs text-gray-500 line-clamp-1"><?php echo e($broker->description); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Rating -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->rating): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?>
                                                <svg class="w-4 h-4 <?php echo e($i < floor($broker->rating) ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current'); ?>" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <span class="ml-2 text-sm font-medium"><?php echo e($broker->rating); ?>/5</span>
                                        <?php else: ?>
                                            <span class="text-sm text-gray-500">N/A</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>

                                <!-- Min Deposit -->
                                <td class="px-6 py-4 text-sm">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->min_deposit): ?>
                                        <span class="font-medium text-gray-900"><?php echo e($broker->min_deposit); ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                <!-- Regulation -->
                                <td class="px-6 py-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->regulation): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?php echo e($broker->regulation); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-sm">-</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                <!-- Experience -->
                                <td class="px-6 py-4 text-sm">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->years_in_business): ?>
                                        <span class="font-medium text-gray-900"><?php echo e($broker->years_in_business); ?> years</span>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                <!-- Action Button -->
                                <td class="px-6 py-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->website): ?>
                                        <a href="<?php echo e($broker->website); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            Visit
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">No Link</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer with Summary -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold"><?php echo e($brokers->count()); ?></span> brokers available • Ranked by rating and experience
                </p>
            </div>
        </div>

        <!-- Additional Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <!-- Top Rated -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brokers->first()): ?>
                <div class="bg-white border-2 border-yellow-300 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">⭐ Top Rated</h3>
                        <span class="text-3xl font-bold text-yellow-600"><?php echo e($brokers->first()->rating); ?>/5</span>
                    </div>
                    <p class="text-gray-700 font-medium"><?php echo e($brokers->first()->name); ?></p>
                    <?php if($brokers->first()->website): ?>
                        <a href="<?php echo e($brokers->first()->website); ?>" target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">Visit →</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Longest Established -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brokers->where('years_in_business', '!=', null)->max('years_in_business')): ?>
                <?php
                    $mostExperienced = $brokers->where('years_in_business', '!=', null)->sortByDesc('years_in_business')->first();
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostExperienced): ?>
                    <div class="bg-white border-2 border-green-300 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">🏆 Most Established</h3>
                            <span class="text-3xl font-bold text-green-600"><?php echo e($mostExperienced->years_in_business); ?>y</span>
                        </div>
                        <p class="text-gray-700 font-medium"><?php echo e($mostExperienced->name); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostExperienced->website): ?>
                            <a href="<?php echo e($mostExperienced->website); ?>" target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">Visit →</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Lowest Min Deposit -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brokers->where('min_deposit', '!=', null)->count() > 0): ?>
                <?php
                    $lowestDeposit = $brokers->where('min_deposit', '!=', null)->sortBy(function($broker) {
                        return (int) str_replace(['$', ','], '', $broker->min_deposit);
                    })->first();
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lowestDeposit): ?>
                    <div class="bg-white border-2 border-purple-300 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">💰 Best Value</h3>
                            <span class="text-2xl font-bold text-purple-600"><?php echo e($lowestDeposit->min_deposit); ?></span>
                        </div>
                        <p class="text-gray-700 font-medium"><?php echo e($lowestDeposit->name); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lowestDeposit->website): ?>
                            <a href="<?php echo e($lowestDeposit->website); ?>" target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">Visit →</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/livewire/broker-recommendations.blade.php ENDPATH**/ ?>