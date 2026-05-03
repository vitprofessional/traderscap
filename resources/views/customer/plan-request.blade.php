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
                            <h3 id="selected-package-name" class="text-xl font-bold text-slate-900">{{ $selectedPackage->name }}</h3>
                            <span id="selected-package-recommended" class="inline-flex items-center rounded-full bg-orange-500 px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-[0.2em] text-white shadow-sm" style="display: {{ $selectedPackage->is_recommended ? 'inline-flex' : 'none' }};">Recommended</span>
                        </div>
                    </div>

                    {{-- Price Band --}}
                    <div class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 px-6 py-6 text-center text-white">
                        <div id="selected-package-price" class="text-4xl font-black tracking-tighter">{{ $formattedPrice }}</div>
                        <div class="mt-1 text-sm font-semibold text-white/95">Min Deposit</div>
                    </div>

                    {{-- Description --}}
                    <div id="selected-package-description-wrap" class="border-b border-slate-100 px-6 py-4 text-center {{ $selectedPackage->description ? '' : 'hidden' }}">
                        <p id="selected-package-description" class="text-sm leading-6 text-slate-500">{{ $selectedPackage->description }}</p>
                    </div>

                    {{-- Facilities --}}
                    <div class="px-6 py-5">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-[0.1em] text-slate-500">Included Facilities</p>
                        <ul id="selected-package-facilities" class="space-y-2">
                            @forelse($facilities as $facility)
                                <li class="flex items-start gap-2 text-sm text-slate-700">
                                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $facility }}
                                </li>
                            @empty
                                <li class="text-sm text-slate-500">No facilities listed</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Right: Request Form --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-5 md:px-8">
                        <h2 class="text-lg font-semibold text-slate-900">Trading Account Details</h2>
                        <p class="mt-1 text-sm text-slate-500">Provide your broker credentials to activate this plan.</p>
                    </div>

                    <form
                        id="plan-request-form"
                        method="POST"
                        action="{{ route('investment-plans.request.submit', $selectedPackage) }}"
                        data-submit-url-template="{{ route('investment-plans.request.submit', ['package' => '__PACKAGE__']) }}"
                        class="px-6 py-6 space-y-5 md:px-8"
                    >
                        @csrf

                        {{-- Package selector (hidden by default, shown as a styled field) --}}
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Selected Package</label>
                            <select
                                id="package_id"
                                name="package_id"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                required
                            >
                                @foreach($planOptions as $id => $name)
                                    <option
                                        value="{{ $id }}"
                                        data-price="{{ $planMeta[$id]['price'] ?? 0 }}"
                                        data-meta='@json($planMeta[$id] ?? [])'
                                        @selected((int) old('package_id', $selectedPackage->id) === (int) $id)
                                    >
                                        {{ $name }}
                                    </option>
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
                                    id="broker_name"
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
                                    id="trading_server"
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
                                    id="trading_id"
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
                                    id="equity"
                                    type="number"
                                    step="0.01"
                                    min="{{ number_format((float) $selectedPackage->price, 2, '.', '') }}"
                                    name="equity"
                                    value="{{ old('equity', $existingPackage?->equity ?? $selectedPackage->price) }}"
                                    placeholder="0.00"
                                    class="w-full rounded-xl border border-slate-300 pl-8 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
                                >
                            </div>
                            <p id="equity-min-hint" class="mt-1 text-xs text-slate-500">Minimum required for selected package: ${{ number_format((float) $selectedPackage->price, 2) }}</p>
                            @error('equity')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Account Equity</p>
                                <p id="equity-preview" class="mt-2 text-2xl font-bold text-cyan-700">$0.00</p>
                                <p class="mt-1 text-xs text-slate-500">Auto-filled from selected package, editable anytime.</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Broker Details</p>
                                <div class="mt-2 space-y-1 text-sm text-slate-700">
                                    <p><span class="font-semibold text-slate-900">Broker:</span> <span id="broker-name-preview">N/A</span></p>
                                    <p><span class="font-semibold text-slate-900">Trading ID:</span> <span id="trading-id-preview">N/A</span></p>
                                    <p><span class="font-semibold text-slate-900">Server:</span> <span id="trading-server-preview">N/A</span></p>
                                </div>
                            </div>
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

    <script>
        (function () {
            const preserveCredentialsOnPackageSwitch = @json(
                $existingPackage
                && $existingPackage->status === 'active'
                && filled($existingPackage->broker_name)
                && filled($existingPackage->trading_id)
                && filled($existingPackage->trading_server)
            );

            const packageSelect = document.getElementById('package_id');
            const form = document.getElementById('plan-request-form');

            const equityInput = document.getElementById('equity');
            const brokerNameInput = document.getElementById('broker_name');
            const tradingIdInput = document.getElementById('trading_id');
            const tradingServerInput = document.getElementById('trading_server');

            const equityPreview = document.getElementById('equity-preview');
            const brokerNamePreview = document.getElementById('broker-name-preview');
            const tradingIdPreview = document.getElementById('trading-id-preview');
            const tradingServerPreview = document.getElementById('trading-server-preview');

            const packageName = document.getElementById('selected-package-name');
            const packageRecommended = document.getElementById('selected-package-recommended');
            const packagePrice = document.getElementById('selected-package-price');
            const packageDescriptionWrap = document.getElementById('selected-package-description-wrap');
            const packageDescription = document.getElementById('selected-package-description');
            const packageFacilities = document.getElementById('selected-package-facilities');
            const equityMinHint = document.getElementById('equity-min-hint');

            if (!packageSelect || !equityInput || !equityPreview) {
                return;
            }

            const formatCurrency = (value) => {
                const numeric = Number(value || 0);
                if (!Number.isFinite(numeric)) {
                    return '$0.00';
                }

                return '$' + numeric.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            };

            const formatMinDeposit = (price) => {
                const numeric = Number(price || 0);
                if (!Number.isFinite(numeric) || numeric <= 0) {
                    return '$0';
                }

                if (numeric < 1000) {
                    return '$' + numeric.toLocaleString(undefined, { maximumFractionDigits: 0 });
                }

                const priceInK = numeric / 1000;
                const cleaned = priceInK.toLocaleString(undefined, {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 1,
                }).replace(/\.0$/, '');

                return '$' + cleaned + 'k';
            };

            const getSelectedMeta = () => {
                const option = packageSelect.options[packageSelect.selectedIndex];
                if (!option) {
                    return {};
                }

                const raw = option.getAttribute('data-meta');
                if (!raw) {
                    return {};
                }

                try {
                    return JSON.parse(raw) || {};
                } catch (error) {
                    return {};
                }
            };

            const updatePreviews = () => {
                equityPreview.textContent = formatCurrency(equityInput.value);
                brokerNamePreview.textContent = (brokerNameInput.value || 'N/A').trim() || 'N/A';
                tradingIdPreview.textContent = (tradingIdInput.value || 'N/A').trim() || 'N/A';
                tradingServerPreview.textContent = (tradingServerInput.value || 'N/A').trim() || 'N/A';
            };

            const updateEquityMinimum = (meta) => {
                const minDeposit = Number(meta.price || 0);
                const safeMinDeposit = Number.isFinite(minDeposit) && minDeposit > 0 ? minDeposit : 0;
                equityInput.min = safeMinDeposit.toFixed(2);

                if (equityMinHint) {
                    equityMinHint.textContent = 'Minimum required for selected package: ' + formatCurrency(safeMinDeposit);
                }

                const currentValue = (equityInput.value || '').trim();
                if (currentValue === '') {
                    equityInput.value = safeMinDeposit.toFixed(2);
                    equityInput.setCustomValidity('');
                    return;
                }

                const currentNumber = Number(currentValue);
                if (Number.isFinite(currentNumber) && currentNumber < safeMinDeposit) {
                    // Keep the form valid by clamping equity to the selected package minimum.
                    equityInput.value = safeMinDeposit.toFixed(2);
                }

                equityInput.setCustomValidity('');
            };

            const renderFacilities = (facilities) => {
                if (!packageFacilities) {
                    return;
                }

                packageFacilities.innerHTML = '';

                if (!Array.isArray(facilities) || facilities.length === 0) {
                    const empty = document.createElement('li');
                    empty.className = 'text-sm text-slate-500';
                    empty.textContent = 'No facilities listed';
                    packageFacilities.appendChild(empty);
                    return;
                }

                facilities.forEach((facility) => {
                    const li = document.createElement('li');
                    li.className = 'flex items-start gap-2 text-sm text-slate-700';

                    const icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    icon.setAttribute('class', 'mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-500');
                    icon.setAttribute('fill', 'none');
                    icon.setAttribute('viewBox', '0 0 24 24');
                    icon.setAttribute('stroke', 'currentColor');

                    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('stroke-linecap', 'round');
                    path.setAttribute('stroke-linejoin', 'round');
                    path.setAttribute('stroke-width', '2.5');
                    path.setAttribute('d', 'M5 13l4 4L19 7');
                    icon.appendChild(path);

                    const text = document.createElement('span');
                    text.textContent = String(facility || '').trim();

                    li.appendChild(icon);
                    li.appendChild(text);
                    packageFacilities.appendChild(li);
                });
            };

            const updatePackageCard = (meta) => {
                if (!meta || typeof meta !== 'object') {
                    return;
                }

                const isRecommended = meta.is_recommended === true || meta.is_recommended === 1 || meta.is_recommended === '1';

                if (packageName) {
                    packageName.textContent = meta.name || 'Package';
                }

                if (packagePrice) {
                    packagePrice.textContent = formatMinDeposit(meta.price);
                }

                if (packageDescriptionWrap && packageDescription) {
                    const desc = String(meta.description || '').trim();
                    packageDescription.textContent = desc;
                    packageDescriptionWrap.classList.toggle('hidden', desc === '');
                }

                if (packageRecommended) {
                    packageRecommended.style.display = isRecommended ? 'inline-flex' : 'none';
                }

                renderFacilities(meta.facilities || []);
            };

            const applyPackageMeta = (meta, forceOverwrite) => {
                const fallbackPrice = Number(meta.price || 0);
                const autoEquity = Number(meta.equity ?? fallbackPrice);
                const safeEquity = Number.isFinite(autoEquity) ? autoEquity : 0;
                const packageBrokerName = String(meta.broker_name || '').trim();
                const packageTradingId = String(meta.trading_id || '').trim();
                const packageTradingServer = String(meta.trading_server || '').trim();

                if (forceOverwrite || (equityInput.value || '').trim() === '') {
                    equityInput.value = safeEquity.toFixed(2);
                }

                if ((forceOverwrite && packageBrokerName !== '') || (brokerNameInput.value || '').trim() === '') {
                    brokerNameInput.value = packageBrokerName;
                }

                if ((forceOverwrite && packageTradingId !== '') || (tradingIdInput.value || '').trim() === '') {
                    tradingIdInput.value = packageTradingId;
                }

                if ((forceOverwrite && packageTradingServer !== '') || (tradingServerInput.value || '').trim() === '') {
                    tradingServerInput.value = packageTradingServer;
                }

                updateEquityMinimum(meta);
                updatePackageCard(meta);
                updatePreviews();
            };

            const updateFormAction = () => {
                if (!form) {
                    return;
                }

                const template = form.getAttribute('data-submit-url-template');
                const packageId = packageSelect.value;

                if (template && packageId) {
                    form.action = template.replace('__PACKAGE__', String(packageId));
                }
            };

            packageSelect.addEventListener('change', function () {
                const meta = getSelectedMeta();
                const shouldOverwriteFromPackage = !preserveCredentialsOnPackageSwitch;
                applyPackageMeta(meta, shouldOverwriteFromPackage);
                updateFormAction();
            });

            [equityInput, brokerNameInput, tradingIdInput, tradingServerInput].forEach((input) => {
                input.addEventListener('input', updatePreviews);
            });

            equityInput.addEventListener('input', function () {
                updateEquityMinimum(getSelectedMeta());
            });

            if (form) {
                form.addEventListener('submit', function (event) {
                    const meta = getSelectedMeta();
                    const minDeposit = Number(meta.price || 0);
                    const currentEquity = Number((equityInput.value || '').trim() || 0);

                    if (Number.isFinite(minDeposit) && currentEquity < minDeposit) {
                        equityInput.value = minDeposit.toFixed(2);
                    }

                    equityInput.setCustomValidity('');
                });
            }

            applyPackageMeta(getSelectedMeta(), false);
            updateFormAction();
            updatePreviews();
        })();
    </script>
</x-layouts.dashboard>
