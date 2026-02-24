<div>
    @if($brokers->isEmpty())
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center">
            <p class="text-gray-600 text-lg">No brokers available at the moment.</p>
        </div>
    @else
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
                        @foreach($brokers as $index => $broker)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Rank -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-100 text-gray-800' : ($index === 2 ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800')) }} font-bold text-sm">
                                        #{{ $index + 1 }}
                                    </div>
                                </td>

                                <!-- Broker Name with Logo -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($broker->logo)
                                            <img src="{{ asset('storage/app/public/' . $broker->logo) }}" alt="{{ $broker->name }}" class="h-10 w-10 object-contain rounded" onerror="this.style.display='none'">
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $broker->name }}</p>
                                            @if($broker->description)
                                                <p class="text-xs text-gray-500 line-clamp-1">{{ $broker->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Rating -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        @if($broker->rating)
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 {{ $i < floor($broker->rating) ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                            <span class="ml-2 text-sm font-medium">{{ $broker->rating }}/5</span>
                                        @else
                                            <span class="text-sm text-gray-500">N/A</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Min Deposit -->
                                <td class="px-6 py-4 text-sm">
                                    @if($broker->min_deposit)
                                        <span class="font-medium text-gray-900">{{ $broker->min_deposit }}</span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>

                                <!-- Regulation -->
                                <td class="px-6 py-4">
                                    @if($broker->regulation)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $broker->regulation }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Experience -->
                                <td class="px-6 py-4 text-sm">
                                    @if($broker->years_in_business)
                                        <span class="font-medium text-gray-900">{{ $broker->years_in_business }} years</span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>

                                <!-- Action Button -->
                                <td class="px-6 py-4">
                                    @if($broker->website)
                                        <a href="{{ $broker->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            Visit
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">No Link</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer with Summary -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">{{ $brokers->count() }}</span> brokers available • Ranked by rating and experience
                </p>
            </div>
        </div>

        <!-- Additional Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <!-- Top Rated -->
            @if($brokers->first())
                <div class="bg-white border-2 border-yellow-300 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">⭐ Top Rated</h3>
                        <span class="text-3xl font-bold text-yellow-600">{{ $brokers->first()->rating }}/5</span>
                    </div>
                    <p class="text-gray-700 font-medium">{{ $brokers->first()->name }}</p>
                    @if($brokers->first()->website)
                        <a href="{{ $brokers->first()->website }}" target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">Visit →</a>
                    @endif
                </div>
            @endif

            <!-- Longest Established -->
            @if($brokers->where('years_in_business', '!=', null)->max('years_in_business'))
                @php
                    $mostExperienced = $brokers->where('years_in_business', '!=', null)->sortByDesc('years_in_business')->first();
                @endphp
                @if($mostExperienced)
                    <div class="bg-white border-2 border-green-300 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">🏆 Most Established</h3>
                            <span class="text-3xl font-bold text-green-600">{{ $mostExperienced->years_in_business }}y</span>
                        </div>
                        <p class="text-gray-700 font-medium">{{ $mostExperienced->name }}</p>
                        @if($mostExperienced->website)
                            <a href="{{ $mostExperienced->website }}" target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">Visit →</a>
                        @endif
                    </div>
                @endif
            @endif

            <!-- Lowest Min Deposit -->
            @if($brokers->where('min_deposit', '!=', null)->count() > 0)
                @php
                    $lowestDeposit = $brokers->where('min_deposit', '!=', null)->sortBy(function($broker) {
                        return (int) str_replace(['$', ','], '', $broker->min_deposit);
                    })->first();
                @endphp
                @if($lowestDeposit)
                    <div class="bg-white border-2 border-purple-300 rounded-lg shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">💰 Best Value</h3>
                            <span class="text-2xl font-bold text-purple-600">{{ $lowestDeposit->min_deposit }}</span>
                        </div>
                        <p class="text-gray-700 font-medium">{{ $lowestDeposit->name }}</p>
                        @if($lowestDeposit->website)
                            <a href="{{ $lowestDeposit->website }}" target="_blank" rel="noopener noreferrer" class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">Visit →</a>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    @endif
</div>
