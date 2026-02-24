<x-layouts.dashboard>
    <div class="max-w-6xl w-full">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-2xl font-semibold">My Plans</h2>
                <p class="text-sm text-gray-600">Track your subscriptions, expiry dates, and manage plan actions.</p>
            </div>
            <a href="{{ route('investment-plans') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">Browse Plans</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @if(!$userPackage)
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <p class="text-sm text-gray-600">You have no plan yet. Start by purchasing a package.</p>
            </div>
        @else
            <!-- Current Plan Details Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Current Plan Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column: Plan & Dates -->
                    <div>
                        <div class="mb-8">
                            <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">Package Name</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $userPackage->package->name ?? 'N/A' }}</p>
                        </div>

                        @if(!empty($userPackage->package?->facilities) && is_array($userPackage->package->facilities))
                            <div class="mb-8">
                                <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">Included Features</p>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    @foreach($userPackage->package->facilities as $facility)
                                        <li class="flex items-start">
                                            <span class="text-green-600 mr-2">✓</span>
                                            <span>{{ $facility }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">Start Date</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $userPackage->starts_at ? $userPackage->starts_at->toFormattedDateString() : 'Pending' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">End Date</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $userPackage->ends_at ? $userPackage->ends_at->toFormattedDateString() : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Status, Equity & Trading Info -->
                    <div>
                        <div class="mb-8">
                            <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">Status</p>
                            <div>
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold
                                    @if($userPackage->status === 'active') bg-green-100 text-green-700
                                    @elseif($userPackage->status === 'expired') bg-red-100 text-red-700
                                    @else bg-amber-100 text-amber-700 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $userPackage->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-8">
                            <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">Account Equity</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $userPackage->equity ? '$' . number_format($userPackage->equity, 2) : 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">Broker Details</p>
                            <div class="text-sm text-gray-700 space-y-1">
                                <p><span class="font-semibold">Broker:</span> {{ $userPackage->broker_name ?? 'N/A' }}</p>
                                <p><span class="font-semibold">Trading ID:</span> {{ $userPackage->trading_id ?? 'N/A' }}</p>
                                <p><span class="font-semibold">Server:</span> {{ $userPackage->trading_server ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-700">
                                <th class="py-3 px-4 font-semibold">Package</th>
                                <th class="py-3 px-4 font-semibold">Starts</th>
                                <th class="py-3 px-4 font-semibold">Ends</th>
                                <th class="py-3 px-4 font-semibold">Status</th>
                                <th class="py-3 px-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 align-top hover:bg-gray-50/60">
                                <td class="py-4 px-4 min-w-[220px]">
                                    <div class="font-semibold text-gray-900">{{ $userPackage->package->name ?? '—' }}</div>
                                    @if(!empty($userPackage->package?->facilities) && is_array($userPackage->package->facilities))
                                        <div class="mt-1 text-xs text-gray-600 leading-relaxed">
                                            {{ implode(' • ', $userPackage->package->facilities) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-700">{{ $userPackage->starts_at ? $userPackage->starts_at->toFormattedDateString() : '—' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap text-gray-700">{{ $userPackage->ends_at ? $userPackage->ends_at->toFormattedDateString() : '—' }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                        @if($userPackage->status === 'active') bg-green-100 text-green-700
                                        @elseif($userPackage->status === 'expired') bg-red-100 text-red-700
                                        @else bg-amber-100 text-amber-700 @endif">
                                        {{ ucfirst($userPackage->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('investment-plans') }}" class="inline-flex items-center px-3 py-2 text-xs font-semibold bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                            Change Plan
                                        </a>

                                        @if($userPackage->status !== 'expired')
                                            <form method="POST" action="{{ route('my-plans.cancel', $userPackage) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 text-xs font-semibold bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">Cancel</button>
                                            </form>
                                        @endif

                                        @if($userPackage->status === 'expired')
                                            <form method="POST" action="{{ route('my-plans.renew', $userPackage) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 text-xs font-semibold bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Renew</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layouts.dashboard>
