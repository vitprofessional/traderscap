<x-layouts.dashboard title="Support Tickets">
    <div class="max-w-4xl w-full">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold">My Support Tickets</h1>
            <a href="{{ route('complaints.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">New Ticket</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow">
            @if($tickets->isEmpty())
                <div class="p-6 text-center text-gray-600">You have no tickets. Create one to contact support.</div>
            @else
                <ul>
                    @foreach($tickets as $t)
                        <li class="p-4 border-b flex items-center justify-between">
                            <div>
                                <a href="{{ route('complaints.show',$t) }}" class="font-medium text-indigo-600">#{{ $t->id }} — {{ $t->subject }}</a>
                                <div class="text-sm text-gray-500">{{ ucfirst($t->status) }} • {{ $t->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="text-sm text-gray-600">Priority: {{ ucfirst($t->priority) }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
