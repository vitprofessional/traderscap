<x-layouts.dashboard>
    <div class="mx-auto w-full max-w-6xl space-y-8 px-2 sm:px-4 lg:px-6">
        <!-- Header Section -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">My Plans</h1>
                    <p class="mt-2 text-sm text-slate-600">Track your subscriptions and manage plan actions.</p>
                </div>
                <a href="{{ route('investment-plans') }}" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                    Browse Plans
                </a>
            </div>
        </section>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(!$userPackage)
            <section class="rounded-2xl border border-slate-200 bg-white px-6 py-12 shadow-sm text-center md:px-8">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
                    <svg class="h-8 w-8 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm text-slate-600">You have no active plan yet. Start by purchasing a package.</p>
                <a href="{{ route('investment-plans') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                    Browse Plans
                </a>
            </section>
        @else
            <!-- Current Plan Details Card -->
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <h2 class="text-lg font-semibold text-slate-900">Current Plan Details</h2>
                </div>
                <div class="px-6 py-8 md:px-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <!-- Left Column: Plan -->
                        <div class="space-y-8">
                            <!-- Package Name -->
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Package Name</p>
                                <p class="text-3xl font-bold text-slate-900">{{ $userPackage->package->name ?? 'N/A' }}</p>
                            </div>

                            <!-- Included Features -->
                            @if(!empty($userPackage->package?->facilities) && is_array($userPackage->package->facilities))
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-3">Included Features</p>
                                    <ul class="space-y-2">
                                        @foreach($userPackage->package->facilities as $facility)
                                            <li class="flex items-start gap-3">
                                                <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span class="text-sm text-slate-700">{{ $facility }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>

                        <!-- Right Column: Status, Equity & Broker Info -->
                        <div class="space-y-8">
                            <!-- Status -->
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-3">Status</p>
                                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold uppercase tracking-[0.08em]
                                    @if($userPackage->status === 'active') bg-emerald-100 text-emerald-800
                                    @elseif($userPackage->status === 'expired') bg-rose-100 text-rose-800
                                    @else bg-amber-100 text-amber-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $userPackage->status)) }}
                                </span>
                            </div>

                            <!-- Min Deposit -->
                            @if($userPackage->package?->price)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Min Deposit</p>
                                    <p class="text-3xl font-bold text-blue-700">${{ number_format($userPackage->package->price, 0) }}</p>
                                </div>
                            @endif

                            <!-- Account Equity -->
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Account Equity</p>
                                <p class="text-3xl font-bold text-cyan-700">{{ $userPackage->equity ? '$' . number_format($userPackage->equity, 2) : 'N/A' }}</p>
                            </div>

                            <!-- Broker Details -->
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-3">Broker Details</p>
                                <div class="space-y-2 text-sm">
                                    <p class="text-slate-700"><span class="font-semibold text-slate-900">Broker:</span> {{ $userPackage->broker_name ?? 'N/A' }}</p>
                                    <p class="text-slate-700"><span class="font-semibold text-slate-900">Trading ID:</span> {{ $userPackage->trading_id ?? 'N/A' }}</p>
                                    <p class="text-slate-700"><span class="font-semibold text-slate-900">Server:</span> {{ $userPackage->trading_server ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Actions Table -->
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <h2 class="text-lg font-semibold text-slate-900">Plan Actions</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Package</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Status</th>
                                <th class="px-6 py-4 text-right font-semibold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-200 transition-colors hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $userPackage->package->name ?? '—' }}</div>
                                    @if(!empty($userPackage->package?->facilities) && is_array($userPackage->package->facilities))
                                        <div class="mt-1 text-xs text-slate-600">
                                            {{ implode(' • ', $userPackage->package->facilities) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.08em]
                                        @if($userPackage->status === 'active') bg-emerald-100 text-emerald-800
                                        @elseif($userPackage->status === 'expired') bg-rose-100 text-rose-800
                                        @else bg-amber-100 text-amber-800 @endif">
                                        {{ ucfirst($userPackage->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('investment-plans') }}" class="inline-flex items-center rounded-full bg-cyan-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-white transition-all hover:bg-cyan-700 active:scale-95">
                                            Change Plan
                                        </a>

                                        @if($userPackage->status !== 'expired')
                                            <form method="POST" action="{{ route('my-plans.cancel', $userPackage) }}" class="inline" onsubmit="return confirm('Are you sure you want to cancel this plan?');">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center rounded-full bg-rose-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-white transition-all hover:bg-rose-700 active:scale-95">Cancel</button>
                                            </form>
                                        @endif

                                        @if($userPackage->status === 'expired')
                                            <form method="POST" action="{{ route('my-plans.renew', $userPackage) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-white transition-all hover:bg-emerald-700 active:scale-95">Renew</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
</x-layouts.dashboard>
