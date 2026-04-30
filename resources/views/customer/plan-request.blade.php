<x-layouts.dashboard :title="'Request Plan — ' . $selectedPackage->name">
    <div class="mx-auto w-full max-w-7xl space-y-6 px-2 py-2 sm:px-4 lg:px-6 lg:py-4">

        {{-- Page Header --}}
        <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-r from-slate-900 via-slate-800 to-cyan-900 px-5 py-7 shadow-sm md:px-8 md:py-8">
            <div class="absolute -top-14 -right-10 h-36 w-36 rounded-full bg-cyan-300/20 blur-2xl"></div>
            <div class="absolute -bottom-16 -left-8 h-36 w-36 rounded-full bg-sky-300/20 blur-2xl"></div>
            <div class="relative flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-cyan-200/90">Plan Activation</p>
                    <h2 class="mt-1 text-2xl font-semibold text-white md:text-3xl">Request: {{ $selectedPackage->name }}</h2>
                    <p class="mt-1 text-sm text-slate-200/80">
                        Account Status:
                        <span class="ml-1 font-semibold text-white">{{ $latestStatus ? ucfirst(str_replace('_', ' ', $latestStatus)) : 'No Plan' }}</span>
                    </p>
                </div>
                <a href="{{ route('investment-plans') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                    ← Back to Plans
                </a>
            </div>
        </section>

        @if($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 lg:items-start">

            {{-- Left: Package Summary Card --}}
            @php
                $facilities = is_array($selectedPackage->facilities) ? $selectedPackage->facilities : [];
                $price = $selectedPackage->price;
                if ($price < 1000) {
                    $formattedPrice = '$' . number_format($price, 0);
                } else {
                    $priceInK = $price / 1000;
                    $formattedPrice = '$' . rtrim(rtrim(number_format($priceInK, 1), '0'), '.') . 'k';
                }
            @endphp
            <div class="lg:col-span-1">
                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-[0_14px_35px_rgba(15,23,42,0.08)]">
                    {{-- Name + Recommended --}}
                    <div class="px-6 pt-6 pb-4 text-center">
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <h3 class="text-xl font-bold text-slate-900">{{ $selectedPackage->name }}</h3>
                            @if($selectedPackage->is_recommended)
                                <span class="inline-flex items-center rounded-full bg-orange-500 px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-[0.2em] text-white shadow-sm">Recommended</span>
                            @endif
                        </div>
                    </div>

                    {{-- Price Band --}}
                    <div class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 px-6 py-6 text-center text-white">
                        <div class="text-4xl font-black tracking-tighter">{{ $formattedPrice }}</div>
                        <div class="mt-1 text-sm font-semibold text-white/95">Min Deposit</div>
                        <div class="mt-1.5 text-xs font-medium text-white/80">/ {{ $selectedPackage->duration_label }}</div>
                    </div>

                    {{-- Description --}}
                    @if($selectedPackage->description)
                        <div class="border-b border-slate-100 px-6 py-4 text-center">
                            <p class="text-sm leading-6 text-slate-500">{{ $selectedPackage->description }}</p>
                        </div>
                    @endif

                    {{-- Facilities --}}
                    @if(!empty($facilities))
                        <div class="px-6 py-5">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.1em] text-slate-500">Included Facilities</p>
                            <ul class="space-y-2">
                                @foreach($facilities as $facility)
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $facility }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Request Form --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-5 md:px-8">
                        <h2 class="text-lg font-semibold text-slate-900">Trading Account Details</h2>
                        <p class="mt-1 text-sm text-slate-500">Provide your broker credentials to activate this plan.</p>
                    </div>

                    <form method="POST" action="{{ route('investment-plans.request.submit', $selectedPackage) }}" class="px-6 py-6 space-y-5 md:px-8">
                        @csrf

                        {{-- Package selector (hidden by default, shown as a styled field) --}}
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Selected Package</label>
                            <select
                                name="package_id"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                required
                            >
                                @foreach($planOptions as $id => $name)
                                    <option value="{{ $id }}" @selected((int) old('package_id', $selectedPackage->id) === (int) $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Broker Name</label>
                                <input
                                    type="text"
                                    name="broker_name"
                                    value="{{ old('broker_name', $existingPackage?->broker_name) }}"
                                    placeholder="e.g. IC Markets, XM"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                    required
                                >
                                @error('broker_name')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Trading Server</label>
                                <input
                                    type="text"
                                    name="trading_server"
                                    value="{{ old('trading_server', $existingPackage?->trading_server) }}"
                                    placeholder="e.g. ICMarkets-Live01"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                    required
                                >
                                @error('trading_server')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Trading ID (MT4/MT5)</label>
                                <input
                                    type="text"
                                    name="trading_id"
                                    value="{{ old('trading_id', $existingPackage?->trading_id) }}"
                                    placeholder="Enter your login ID"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                    required
                                >
                                @error('trading_id')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Trading Password</label>
                                <input
                                    type="text"
                                    name="trading_password"
                                    value="{{ old('trading_password', $existingPackage?->trading_password) }}"
                                    placeholder="Enter investor/read-only password"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                    required
                                >
                                @error('trading_password')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Account Equity <span class="font-normal text-slate-400">(optional)</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">$</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="equity"
                                    value="{{ old('equity', $existingPackage?->equity) }}"
                                    placeholder="0.00"
                                    class="w-full rounded-xl border border-slate-300 pl-8 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                >
                            </div>
                            @error('equity')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-8 py-3 text-sm font-bold uppercase tracking-[0.12em] text-white shadow-md shadow-cyan-600/25 transition-all hover:bg-cyan-700 active:scale-95">
                                Submit Request
                            </button>
                            <a href="{{ route('investment-plans') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-8 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-slate-700 transition-colors hover:bg-slate-50">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-layouts.dashboard>
