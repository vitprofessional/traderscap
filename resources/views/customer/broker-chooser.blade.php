<x-layouts.dashboard>
    <div class="max-w-5xl w-full mx-auto space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-900">Custom Best Broker</h2>
                    <p class="text-gray-600 mt-1">Answer the questions below and get your best broker matches.</p>
                </div>

                <a href="{{ route('find-broker') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Broker List
                </a>
            </div>
        </div>

        @livewire('quiz-page', ['embedded' => true], key('custom-best-broker-quiz'))
    </div>
</x-layouts.dashboard>
