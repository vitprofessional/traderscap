<x-layouts.dashboard>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-600 to-blue-700">
                <h2 class="text-2xl font-semibold text-white">Join Our Affiliate Program</h2>
                <p class="text-blue-100 mt-1">Complete the form below to apply for our affiliate program.</p>
            </div>

            <form method="POST" action="{{ route('partners.store-application') }}" class="p-6 space-y-6">
                @csrf

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-2">What You'll Get:</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>✓ 10% commission on every successful referral</li>
                        <li>✓ Recurring commissions from customer renewals</li>
                        <li>✓ Real-time affiliate dashboard with analytics</li>
                        <li>✓ Monthly commission payouts</li>
                        <li>✓ Dedicated affiliate support</li>
                    </ul>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tell Us About Your Motivation</label>
                    <textarea
                        name="motivation"
                        rows="5"
                        placeholder="Explain why you want to join our affiliate program, how you plan to promote it, and what audience you have..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                        required
                    >{{ old('motivation') }}</textarea>
                    @error('motivation')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Minimum 50 characters</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Website or Social Media URL (Optional)</label>
                    <input
                        type="url"
                        name="website_url"
                        placeholder="https://your-website.com or https://your-blog.com"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('website_url') }}"
                    >
                    @error('website_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">This helps us understand your audience</p>
                </div>

                <div class="space-y-3">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="agree_terms"
                            class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ old('agree_terms') ? 'checked' : '' }}
                            required
                        >
                        <span class="text-sm text-gray-700">
                            I agree to the affiliate program terms and conditions. I understand that commissions are paid monthly after verification of customer purchases.
                        </span>
                    </label>
                    @error('agree_terms')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center gap-3">
                    <button type="submit" class="px-6 py-3 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition-colors">
                        Submit Application
                    </button>
                    <a href="{{ route('partners') }}" class="px-6 py-3 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- FAQ Section -->
        <div class="mt-8 bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-6">Frequently Asked Questions</h3>
            <div class="space-y-4">
                <details class="border-b border-gray-200 pb-4">
                    <summary class="font-medium text-gray-800 cursor-pointer hover:text-blue-600">How long does approval take?</summary>
                    <p class="text-gray-600 mt-2 text-sm">We typically review applications within 24-48 hours. You'll receive an email notification once your application is reviewed.</p>
                </details>
                <details class="border-b border-gray-200 pb-4">
                    <summary class="font-medium text-gray-800 cursor-pointer hover:text-blue-600">How do I track my referrals?</summary>
                    <p class="text-gray-600 mt-2 text-sm">Once approved, you'll have access to your affiliate dashboard where you can track all referrals, commissions, and earnings in real-time.</p>
                </details>
                <details class="pb-4">
                    <summary class="font-medium text-gray-800 cursor-pointer hover:text-blue-600">When are commissions paid?</summary>
                    <p class="text-gray-600 mt-2 text-sm">Commissions are calculated monthly and paid out via bank transfer. We process payouts on the first week of each month for the previous month's earnings.</p>
                </details>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
