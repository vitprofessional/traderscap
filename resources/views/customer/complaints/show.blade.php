<x-layouts.dashboard :title="'Ticket #'.$ticket->id">
    <div class="mx-auto w-full max-w-3xl space-y-6 px-2 sm:px-4 lg:px-6">
        <!-- Header Section -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-6 shadow-sm md:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Ticket #{{ $ticket->id }}</h1>
                    <p class="mt-1 text-base font-medium text-slate-700">{{ $ticket->subject }}</p>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.08em] {{ $ticket->status === 'open' ? 'bg-emerald-100 text-emerald-800' : ($ticket->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800') }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.08em] {{ $ticket->priority === 'high' ? 'bg-rose-100 text-rose-800' : ($ticket->priority === 'normal' ? 'bg-cyan-100 text-cyan-800' : 'bg-slate-100 text-slate-800') }}">
                            {{ ucfirst($ticket->priority) }} Priority
                        </span>
                    </div>
                </div>
                <div class="flex flex-col gap-2 md:flex-row md:items-center">
                    @if($ticket->status !== 'closed')
                        <form method="POST" action="{{ route('complaints.close', $ticket) }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center rounded-full bg-rose-600 px-4 py-3 text-xs font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-rose-700 active:scale-95">
                                Close Ticket
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('complaints') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-slate-700 transition-colors hover:bg-slate-50">
                        ← Back
                    </a>
                </div>
            </div>
        </section>

        <!-- Original Ticket Section -->
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                <h2 class="text-sm font-semibold uppercase tracking-[0.08em] text-slate-600">Original Issue</h2>
            </div>
            <div class="px-6 py-6 md:px-8">
                <div class="space-y-4">
                    <p class="text-sm leading-relaxed text-slate-700">{{ $ticket->description }}</p>
                    @if($ticket->attachment)
                        <div class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                            <svg class="h-5 w-5 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <a href="{{ asset('storage/app/public/'.$ticket->attachment) }}" target="_blank" class="ml-3 text-sm font-semibold text-cyan-600 hover:text-cyan-700">
                                View Attachment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Chat Section -->
        <div>
            @livewire('ticket-chat', ['ticket' => $ticket])
        </div>

        <!-- Actions Section -->
        @if($ticket->status !== 'closed')
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.08em] text-slate-600">Ticket Actions</h2>
                </div>
                <div class="px-6 py-6 md:px-8">
                    <div class="space-y-4">
                        <form method="POST" action="{{ route('complaints.update-priority', $ticket) }}" class="max-w-md">
                            @csrf
                            <label for="priority" class="block text-sm font-semibold text-slate-900">Change Priority</label>
                            <div class="mt-3 flex items-end gap-3">
                                <select
                                    name="priority"
                                    id="priority"
                                    class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm transition-colors focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 focus:outline-none"
                                >
                                    <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Low Priority</option>
                                    <option value="normal" {{ $ticket->priority === 'normal' ? 'selected' : '' }}>Normal Priority</option>
                                    <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>High Priority</option>
                                </select>
                                <button type="submit" class="inline-flex items-center rounded-full bg-cyan-600 px-6 py-2.5 text-xs font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        @endif
    </div>
</x-layouts.dashboard>
