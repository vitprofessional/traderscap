<x-filament::page>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold">Reply Ticket</h2>
    </x-slot>

    @php
        $ticket = \App\Models\Ticket::find(request()->query('ticket') ?? $ticket_id ?? null);
    @endphp

    <div class="max-w-5xl mx-auto p-6">
        <h3 class="text-lg font-medium mb-4">Ticket #{{ $ticket?->id ?? '' }}</h3>

        @if($ticket)
            <div class="bg-white shadow-sm rounded-lg p-6">
                <livewire:admin-ticket-chat :ticket="$ticket" wire:key="admin-ticket-chat-{{ $ticket->id }}" />
            </div>
        @else
            <div class="text-sm text-gray-600">Ticket not found.</div>
        @endif
    </div>
</x-filament::page>
