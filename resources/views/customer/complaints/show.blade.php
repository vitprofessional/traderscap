<x-layouts.dashboard :title="'Ticket #'.$ticket->id">
    <div class="max-w-3xl w-full">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-xl font-semibold">#{{ $ticket->id }} — {{ $ticket->subject }}</h1>
                <div class="text-sm text-gray-500">Status: {{ ucfirst($ticket->status) }} • Priority: {{ ucfirst($ticket->priority) }}</div>
            </div>
            <div>
                <a href="{{ route('complaints') }}" class="text-sm text-gray-600 hover:underline">Back to tickets</a>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow mb-4">
            <div class="text-sm text-gray-700">{{ $ticket->description }}</div>
            @if($ticket->attachment)
                <div class="mt-3">
                    <a href="{{ asset('storage/app/public/'.$ticket->attachment) }}" target="_blank" class="text-sm text-indigo-600 hover:underline">View attachment</a>
                </div>
            @endif
        </div>

        <div>
            @livewire('ticket-chat', ['ticket' => $ticket])
        </div>
    </div>
</x-layouts.dashboard>
