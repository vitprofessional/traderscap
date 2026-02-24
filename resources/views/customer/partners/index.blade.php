<x-layouts.dashboard>
    <div class="max-w-6xl w-full">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold">Partners Corner</h2>
            <p class="text-sm text-gray-600">Join our affiliate program and earn commissions from referrals.</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 text-green-800 rounded-lg border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-4 p-4 bg-blue-50 text-blue-800 rounded-lg border border-blue-200">
                {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 text-red-800 rounded-lg border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if(!$affiliate)
            <!-- Not an Affiliate Yet -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Benefits Card -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold mb-4">Why Join Our Affiliate Program?</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start gap-3">
                            <span class="h-2 w-2 rounded-full bg-blue-600 mt-2 flex-shrink-0"></span>
                            <span>Earn 10% commission on every referral</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="h-2 w-2 rounded-full bg-blue-600 mt-2 flex-shrink-0"></span>
                            <span>Lifetime commissions from your referrals</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="h-2 w-2 rounded-full bg-blue-600 mt-2 flex-shrink-0"></span>
                            <span>Real-time tracking analytics</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="h-2 w-2 rounded-full bg-blue-600 mt-2 flex-shrink-0"></span>
                            <span>Monthly payouts</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="h-2 w-2 rounded-full bg-blue-600 mt-2 flex-shrink-0"></span>
                            <span>Dedicated support team</span>
                        </li>
                    </ul>
                </div>

                <!-- How It Works -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-semibold mb-4">How It Works</h3>
                    <div class="space-y-4 text-gray-700">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                            <div>
                                <p class="font-medium">Apply to Join</p>
                                <p class="text-sm text-gray-600">Submit your affiliate application</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                            <div>
                                <p class="font-medium">Get Approved</p>
                                <p class="text-sm text-gray-600">We review and approve your application</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                            <div>
                                <p class="font-medium">Share Your Code</p>
                                <p class="text-sm text-gray-600">Distribute your unique referral code</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">4</div>
                            <div>
                                <p class="font-medium">Earn Commissions</p>
                                <p class="text-sm text-gray-600">Get paid for successful referrals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apply Button -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-8 text-white text-center">
                <h3 class="text-2xl font-semibold mb-3">Ready to Start Earning?</h3>
                <p class="mb-6 text-blue-100">Join our affiliate program today and start earning commissions immediately.</p>
                <a href="{{ route('partners.apply') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                    Apply to Join
                </a>
            </div>
        @endif
    </div>
</x-layouts.dashboard>
