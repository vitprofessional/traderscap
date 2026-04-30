<x-layouts.dashboard title="Support Tickets">
    <div class="mx-auto w-full max-w-6xl space-y-8 px-2 sm:px-4 lg:px-6">
        <!-- Header Section -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Support Tickets</h1>
                    <p class="mt-2 text-sm text-slate-600">Track and manage your support requests with our team.</p>
                </div>
                <a href="{{ route('complaints.create') }}" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                    New Ticket
                </a>
            </div>
        </section>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($tickets->isEmpty())
            <section class="rounded-2xl border border-slate-200 bg-white px-6 py-12 shadow-sm text-center md:px-8">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                    <svg class="h-8 w-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-sm text-slate-600 mb-4">You have no support tickets yet.</p>
                <p class="text-xs text-slate-500 mb-6">Create a ticket to report an issue or contact our support team.</p>
                <a href="{{ route('complaints.create') }}" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                    Create Ticket
                </a>
            </section>
        @else
            <!-- Tickets List -->
            <div class="space-y-4">
                @foreach($tickets as $t)
                    <a href="{{ route('complaints.show', $t) }}" class="group block rounded-2xl border border-slate-200 bg-white px-6 py-6 shadow-sm transition-all hover:border-cyan-300 hover:shadow-md md:px-8">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <!-- Left: Ticket Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 uppercase tracking-[0.06em]">
                                        #{{ $t->id }}
                                    </span>
                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.06em]
                                        @if($t->status === 'open') bg-emerald-100 text-emerald-800
                                        @elseif($t->status === 'pending') bg-amber-100 text-amber-800
                                        @else bg-slate-100 text-slate-800 @endif">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 group-hover:text-cyan-700 transition-colors mb-2 line-clamp-2">
                                    {{ $t->subject }}
                                </h3>
                                <p class="text-xs text-slate-500">{{ $t->created_at->diffForHumans() }}</p>
                            </div>

                            <!-- Right: Priority & Arrow -->
                            <div class="flex items-center gap-4 md:flex-col md:items-end">
                                <!-- Priority Badge -->
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.06em]
                                    @if($t->priority === 'high') bg-rose-100 text-rose-800
                                    @elseif($t->priority === 'normal') bg-cyan-100 text-cyan-800
                                    @else bg-slate-100 text-slate-800 @endif">
                                    {{ ucfirst($t->priority) }} Priority
                                </span>
                                <!-- Arrow Icon -->
                                <svg class="h-5 w-5 text-slate-400 group-hover:text-cyan-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.dashboard>
