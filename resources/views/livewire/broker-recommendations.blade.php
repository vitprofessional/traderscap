<div class="space-y-8">
    @if($brokers->isEmpty())
        <div class="rounded-2xl border border-slate-200 bg-white px-6 py-12 shadow-sm text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <p class="text-sm text-slate-600">No brokers available at the moment.</p>
        </div>
    @else
        <!-- Brokers Table Section -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <!-- Table Header -->
            <div class="border-b border-slate-200 px-6 py-6">
                <h2 class="text-lg font-semibold text-slate-900">Available Brokers</h2>
                <p class="mt-1 text-xs text-slate-600">Ranked by rating, years in business, and competitive features</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50">
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Rank</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Broker</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Rating</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Min. Deposit</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Regulation</th>
                            <th class="px-6 py-4 text-left font-semibold text-slate-700">Experience</th>
                            <th class="px-6 py-4 text-right font-semibold text-slate-700">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($brokers as $index => $broker)
                            <tr class="transition-colors hover:bg-slate-50">
                                <!-- Rank -->
                                <td class="px-6 py-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full font-bold text-sm text-white {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : ($index === 1 ? 'bg-gradient-to-br from-slate-400 to-slate-600' : ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-blue-400 to-blue-600')) }}">
                                        #{{ $index + 1 }}
                                    </div>
                                </td>

                                <!-- Broker Name with Logo -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($broker->logo)
                                            <img src="{{ asset('storage/app/public/' . $broker->logo) }}" alt="{{ $broker->name }}" class="h-12 w-12 flex-shrink-0 object-contain rounded-lg bg-slate-50 p-1" onerror="this.style.display='none'">
                                        @endif
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $broker->name }}</p>
                                            @if($broker->description)
                                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $broker->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Rating -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($broker->rating)
                                            <div class="flex gap-0.5">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg class="h-4 w-4 {{ $i < floor($broker->rating) ? 'fill-amber-400 text-amber-400' : 'fill-slate-200 text-slate-200' }}" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="font-semibold text-slate-900">{{ $broker->rating }}/5</span>
                                        @else
                                            <span class="text-slate-500">—</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Min Deposit -->
                                <td class="px-6 py-4">
                                    @if($broker->min_deposit)
                                        <span class="font-semibold text-slate-900">{{ $broker->min_deposit }}</span>
                                    @else
                                        <span class="text-slate-500">—</span>
                                    @endif
                                </td>

                                <!-- Regulation -->
                                <td class="px-6 py-4">
                                    @if($broker->regulation)
                                        <span class="inline-flex items-center rounded-full bg-cyan-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.06em] text-cyan-800">
                                            {{ $broker->regulation }}
                                        </span>
                                    @else
                                        <span class="text-slate-500 text-sm">—</span>
                                    @endif
                                </td>

                                <!-- Experience -->
                                <td class="px-6 py-4">
                                    @if($broker->years_in_business)
                                        <span class="font-semibold text-slate-900">{{ $broker->years_in_business }} yrs</span>
                                    @else
                                        <span class="text-slate-500">—</span>
                                    @endif
                                </td>

                                <!-- Action Button -->
                                <td class="px-6 py-4 text-right">
                                    @if($broker->website)
                                        <a href="{{ $broker->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-white transition-all hover:bg-cyan-700 active:scale-95">
                                            Visit
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-sm">No Link</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                <p class="text-xs text-slate-600">
                    <span class="font-semibold text-slate-900">{{ $brokers->count() }}</span> brokers available • Ranked by rating, experience, and features
                </p>
            </div>
        </div>

        <!-- Summary Highlights Section -->
        <div>
            <h2 class="mb-6 text-lg font-semibold text-slate-900">Highlights</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Top Rated -->
                @if($brokers->first())
                    <div class="rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 to-amber-100 px-6 py-8 shadow-sm">
                        <div class="mb-6 flex items-center justify-between">
                            <h3 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.08em] text-amber-900">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Top Rated
                            </h3>
                            <span class="text-2xl font-bold text-amber-700">{{ $brokers->first()->rating }}/5</span>
                        </div>
                        <p class="mb-4 font-semibold text-slate-900">{{ $brokers->first()->name }}</p>
                        @if($brokers->first()->website)
                            <a href="{{ $brokers->first()->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-amber-800 hover:text-amber-900 transition-colors">
                                Visit Site
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Most Established -->
                @if($brokers->where('years_in_business', '!=', null)->max('years_in_business'))
                    @php
                        $mostExperienced = $brokers->where('years_in_business', '!=', null)->sortByDesc('years_in_business')->first();
                    @endphp
                    @if($mostExperienced)
                        <div class="rounded-2xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-emerald-100 px-6 py-8 shadow-sm">
                            <div class="mb-6 flex items-center justify-between">
                                <h3 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.08em] text-emerald-900">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a6 6 0 016 6v3a3 3 0 01-3 3H7a1 1 0 100 2h2a5 5 0 005-5v-3a8 8 0 00-8-8H6a1 1 0 000-2H4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Most Established
                                </h3>
                                <span class="text-2xl font-bold text-emerald-700">{{ $mostExperienced->years_in_business }}+</span>
                            </div>
                            <p class="mb-4 font-semibold text-slate-900">{{ $mostExperienced->name }}</p>
                            @if($mostExperienced->website)
                                <a href="{{ $mostExperienced->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-800 hover:text-emerald-900 transition-colors">
                                    Visit Site
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif
                @endif

                <!-- Best Value -->
                @if($brokers->where('min_deposit', '!=', null)->count() > 0)
                    @php
                        $lowestDeposit = $brokers->where('min_deposit', '!=', null)->sortBy(function($broker) {
                            return (int) str_replace(['$', ','], '', $broker->min_deposit);
                        })->first();
                    @endphp
                    @if($lowestDeposit)
                        <div class="rounded-2xl border border-cyan-200 bg-gradient-to-br from-cyan-50 to-cyan-100 px-6 py-8 shadow-sm">
                            <div class="mb-6 flex items-center justify-between">
                                <h3 class="flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.08em] text-cyan-900">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.16 2.75a.75.75 0 00-1.32 0l-1.424 3.469a.75.75 0 01-.574.544l-3.613.528c-1.124.163-1.574 1.514-.754 2.293l2.614 2.431a.75.75 0 00.217.838l-3.149 3.848c-.94 1.15.106 2.84 1.426 2.84.373 0 .75-.114 1.078-.352l3.341-2.362a.75.75 0 00.906 0l3.341 2.362c.327.238.705.352 1.078.352 1.32 0 2.365-1.69 1.426-2.84l-3.15-3.848a.75.75 0 00.217-.838l2.614-2.431c.82-.78.37-2.13-.753-2.293l-3.614-.528a.75.75 0 01-.574-.544L8.16 2.75z" />
                                    </svg>
                                    Best Value
                                </h3>
                                <span class="text-2xl font-bold text-cyan-700">{{ $lowestDeposit->min_deposit }}</span>
                            </div>
                            <p class="mb-4 font-semibold text-slate-900">{{ $lowestDeposit->name }}</p>
                            @if($lowestDeposit->website)
                                <a href="{{ $lowestDeposit->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-cyan-800 hover:text-cyan-900 transition-colors">
                                    Visit Site
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endif
</div>
