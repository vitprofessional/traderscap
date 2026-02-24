<x-layouts.dashboard>
    <div class="max-w-7xl w-full space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-900">Find Your Best Broker</h2>
                    <p class="text-gray-600 mt-1">Browse the top brokers or use custom matching based on your profile.</p>
                </div>

                <a href="{{ route('custom-best-broker') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Custom Best Broker</span>
                </a>
            </div>
        </div>

        <!-- Broker Results -->
        <div class="space-y-6">
            @livewire('broker-recommendations')
        </div>
    </div>
</x-layouts.dashboard>
