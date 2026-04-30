<x-layouts.dashboard>
    <div class="mx-auto w-full max-w-6xl space-y-8 px-2 sm:px-4 lg:px-6">
        <!-- Header Section -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Find Your Best Broker</h1>
                    <p class="mt-2 text-sm text-slate-600">Browse top brokers or use custom matching based on your trading profile.</p>
                </div>
                <a href="{{ route('custom-best-broker') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Custom Match</span>
                </a>
            </div>
        </section>

        <!-- Broker Results -->
        <div>
            @livewire('broker-recommendations')
        </div>
    </div>
</x-layouts.dashboard>
