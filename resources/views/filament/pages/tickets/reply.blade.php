<x-filament-panels::page>
    @php
        $ticket = \App\Models\Ticket::with(['user', 'messages.user'])->find(request()->query('ticket') ?? $ticket_id ?? null);
    @endphp

    @if($ticket)
        {{-- Page sub-header --}}
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;flex-wrap:wrap">
            <a href="{{ url(config('filament.path', 'admin') . '/complaints') }}"
               style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.82rem;color:#64748b;text-decoration:none;padding:0.35rem 0.7rem;border:1px solid #e2e8f0;border-radius:6px;background:#f8fafc;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                All tickets
            </a>
            <span style="font-size:0.82rem;color:#94a3b8">/</span>
            <span style="font-size:0.82rem;color:#334155;font-weight:600">Ticket #{{ $ticket->id }}</span>

            @php
                $statusColor = match($ticket->status) {
                    'open' => ['bg'=>'#fef3c7','text'=>'#92400e','dot'=>'#f59e0b'],
                    'resolved' => ['bg'=>'#dcfce7','text'=>'#14532d','dot'=>'#22c55e'],
                    default => ['bg'=>'#f1f5f9','text'=>'#475569','dot'=>'#94a3b8'],
                };
            @endphp
            <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.78rem;font-weight:600;padding:0.3rem 0.75rem;border-radius:999px;background:{{ $statusColor['bg'] }};color:{{ $statusColor['text'] }}">
                <span style="width:6px;height:6px;border-radius:50%;background:{{ $statusColor['dot'] }}"></span>
                {{ ucfirst($ticket->status) }}
            </span>
        </div>

        <livewire:admin-ticket-chat :ticket="$ticket" wire:key="admin-ticket-chat-{{ $ticket->id }}" />
    @else
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:5rem 2rem;text-align:center">
            <div style="width:64px;height:64px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin-bottom:1rem">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            </div>
            <p style="font-size:1rem;font-weight:600;color:#334155;margin:0 0 0.35rem">Ticket not found</p>
            <p style="font-size:0.875rem;color:#94a3b8;margin:0">The ticket you're looking for doesn't exist or has been deleted.</p>
        </div>
    @endif
</x-filament-panels::page>
