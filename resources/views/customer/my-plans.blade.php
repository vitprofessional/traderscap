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
