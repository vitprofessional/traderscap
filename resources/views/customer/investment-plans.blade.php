<x-layouts.dashboard>
    <div class="max-w-6xl w-full">
        <div class="mb-6">
            <div>
                <h2 class="text-2xl font-semibold">Investment Plans</h2>
                <p class="text-sm text-gray-600">Choose a plan, review facilities, and activate in one click.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @if($plans->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <p class="text-sm text-gray-600">No plans are available right now. Please check back later.</p>
            </div>
        @else
            <section class="rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-900 to-fuchsia-900 p-5 md:p-8 mb-8">
                <div class="text-center mb-6">
                    <h3 class="text-white text-2xl font-semibold">Pricing</h3>
                    <p class="text-indigo-100 text-sm mt-1">Simple plans with clear facilities and duration.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @php
                        $featuredPlanId = optional($plans->sortByDesc('price')->first())->id;
                    @endphp

                    @foreach($plans as $plan)
                        @php
                            $isFeatured = $featuredPlanId === $plan->id;
                            $isCurrentPlan = isset($currentPackageId) && (int) $currentPackageId === (int) $plan->id;
                            $facilities = is_array($plan->facilities) ? $plan->facilities : [];
                        @endphp

                        <article class="rounded-xl overflow-hidden border {{ $isCurrentPlan ? 'border-emerald-300 ring-2 ring-emerald-300/70 shadow-xl' : ($isFeatured ? 'border-fuchsia-300 shadow-xl ring-1 ring-fuchsia-300/60' : 'border-slate-200 shadow-lg') }} bg-white">
                            <div class="px-5 py-4 {{ $isFeatured ? 'bg-fuchsia-600 text-white' : 'bg-slate-600 text-white' }}">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-semibold">{{ $plan->name }}</h4>
                                        <p class="text-xs {{ $isFeatured ? 'text-fuchsia-100' : 'text-slate-200' }} mt-1">{{ (int) $plan->duration_days }} days plan</p>
                                    </div>
                                    @if($isCurrentPlan)
                                        <span class="text-[10px] font-semibold uppercase tracking-wide bg-emerald-500 text-white px-2 py-1 rounded-full">Current Plan</span>
                                    @elseif($isFeatured)
                                        <span class="text-[10px] font-semibold uppercase tracking-wide bg-white/20 px-2 py-1 rounded-full">Popular</span>
                                    @endif
                                </div>

                                <div class="mt-3">
                                    <span class="text-4xl font-bold leading-none">${{ number_format($plan->price, 0) }}</span>
                                    <span class="text-xs {{ $isFeatured ? 'text-fuchsia-100' : 'text-slate-200' }}"> /{{ (int) $plan->duration_days }} days</span>
                                </div>
                            </div>

                            <div class="px-5 py-4">
                                <p class="text-xs text-gray-600 leading-relaxed min-h-10">{{ $plan->description ?: 'No details provided.' }}</p>

                                <ul class="mt-3 space-y-2 text-sm text-gray-700">
                                    @forelse($facilities as $facility)
                                        <li class="flex items-start gap-2">
                                            <span class="mt-1 h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
                                            <span>{{ $facility }}</span>
                                        </li>
                                    @empty
                                        <li class="text-xs text-gray-500">No facilities listed</li>
                                    @endforelse
                                </ul>

                                @if($isCurrentPlan)
                                    <div class="mt-5 w-full inline-flex justify-center items-center px-3 py-2.5 rounded-full text-xs font-semibold tracking-wide uppercase bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        Current Plan
                                    </div>
                                @else
                                    @php
                                        $buttonLabel = 'Purchase';

                                        if (!empty($hasAnyPackage)) {
                                            $buttonLabel = (isset($currentPackagePrice) && (float) $plan->price < (float) $currentPackagePrice)
                                                ? 'Downgrade'
                                                : 'Upgrade';
                                        }
                                    @endphp
                                    <a href="{{ route('investment-plans.request', $plan) }}" class="mt-5 w-full inline-flex justify-center items-center px-3 py-2.5 rounded-full text-xs font-semibold tracking-wide uppercase {{ $isFeatured ? 'bg-fuchsia-600 hover:bg-fuchsia-700 text-white' : 'bg-slate-700 hover:bg-slate-800 text-white' }} transition-colors">
                                        {{ $buttonLabel }}
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            @php
                $steps = [
                    ['number' => '01', 'title' => 'Discover', 'points' => ['Determine your financial goals', 'Identify your risk profile']],
                    ['number' => '02', 'title' => 'Propose', 'points' => ['Pick the right package level', 'Match facilities with your objectives']],
                    ['number' => '03', 'title' => 'Implement', 'points' => ['Submit your trading details', 'Your plan moves to pending verification']],
                    ['number' => '04', 'title' => 'Guide', 'points' => ['Receive regular plan updates', 'Renew or adjust as needed']],
                ];
            @endphp

            <section class="mt-8">
                <div class="text-center mb-6">
                    <h3 class="text-3xl font-semibold text-slate-800">Four Step Investment Planning Process</h3>
                    <p class="text-sm text-gray-600 mt-2">A simple process to choose and manage plans confidently.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    @foreach($steps as $step)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 py-2 border-b border-gray-200 text-2xl font-semibold text-slate-900">{{ $step['number'] }}</div>
                            <div class="px-4 py-3 bg-cyan-600 text-white text-3xl font-semibold leading-none">{{ $step['title'] }}</div>
                            <div class="p-4">
                                <ul class="space-y-2 text-sm text-gray-700">
                                    @foreach($step['points'] as $point)
                                        <li class="flex items-start gap-2">
                                            <span class="mt-1 h-1.5 w-1.5 rounded-full bg-cyan-700"></span>
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-layouts.dashboard>
