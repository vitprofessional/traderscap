<x-layouts.dashboard>
    <div class="max-w-7xl w-full">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-3xl font-semibold">Affiliate Dashboard</h2>
                    <p class="text-gray-600 mt-1">Manage your referrals and track your earnings</p>
                </div>
                <div class="text-right">
                    @if($affiliate->isPending())
                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full">Pending Approval</span>
                    @elseif($affiliate->isRejected())
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">Rejected</span>
                    @else
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">Active</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Referrals</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['total_referrals'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xl">📊</div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Active Referrals</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['active_referrals'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 text-xl">✓</div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Commissions</p>
                        <p class="text-3xl font-bold mt-2">${{ number_format($stats['total_commissions'], 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 text-xl">💰</div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Pending Payouts</p>
                        <p class="text-3xl font-bold mt-2">${{ number_format($stats['pending_commissions'], 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 text-xl">⏳</div>
                </div>
            </div>
        </div>

        <!-- Referral Code Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4">Your Referral Code</h3>
            <div class="flex items-center gap-3">
                <div class="flex-1">
                    <div class="bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 font-mono text-lg font-bold text-center">
                        {{ $affiliate->referral_code }}
                    </div>
                </div>
                <button 
                    onclick="copyToClipboard('{{ $affiliate->referral_code }}')"
                    class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors"
                >
                    Copy Code
                </button>
                <a 
                    href="javascript:void(0)"
                    onclick="getReferralLink()"
                    class="px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors"
                >
                    Get Link
                </a>
            </div>
            <p class="text-sm text-gray-600 mt-3">Share this code or link with your network to generate referrals</p>
        </div>

        <!-- Referrals Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Recent Referrals</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Referred User</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Commission</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($referrals as $referral)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">{{ $referral->referredUser->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $referral->referredUser->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                        @if($referral->status === 'completed') bg-green-100 text-green-800
                                        @elseif($referral->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ ucfirst($referral->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">${{ number_format($referral->commission_earned, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $referral->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No referrals yet. Start sharing your code!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($referrals->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $referrals->links() }}
                </div>
            @endif
        </div>

        <!-- Commissions Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Commission History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Paid Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($commissions as $commission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-semibold">${{ number_format($commission->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                        @if($commission->status === 'paid') bg-green-100 text-green-800
                                        @elseif($commission->status === 'approved') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif
                                    ">
                                        {{ ucfirst($commission->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($commission->paid_at)
                                        {{ $commission->paid_at->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $commission->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No commissions yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($commissions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $commissions->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Referral code copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }

        function getReferralLink() {
            // Get CSRF token from meta tag or document
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                || document.querySelector('input[name="_token"]')?.value;

            if (!csrfToken) {
                alert('Error: Security token not found. Please refresh the page.');
                return;
            }

            fetch('{{ route("affiliate.referral-link") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }
                navigator.clipboard.writeText(data.link).then(() => {
                    alert('Referral link copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy link:', err);
                    alert('Link: ' + data.link);
                });
            })
            .catch(err => {
                console.error('Error fetching referral link:', err);
                alert('Error getting referral link. Please try again.');
            });
        }
    </script>
</x-layouts.dashboard>
