<x-layouts.dashboard>
    <div>
        <h2 class="text-xl font-semibold mb-4">My Plans</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @if($userPackages->isEmpty())
            <p class="text-sm text-gray-600">You have no plans yet.</p>
        @else
            <table class="w-full text-left text-sm bg-white rounded shadow">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 px-3">Package</th>
                        <th class="py-2 px-3">Starts</th>
                        <th class="py-2 px-3">Ends</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userPackages as $up)
                        <tr class="border-b">
                            <td class="py-2 px-3">{{ $up->package->name ?? '—' }}</td>
                            <td class="py-2 px-3">{{ $up->starts_at ? $up->starts_at->toDateString() : '—' }}</td>
                            <td class="py-2 px-3">{{ $up->ends_at ? $up->ends_at->toDateString() : '—' }}</td>
                            <td class="py-2 px-3">{{ ucfirst($up->status) }}</td>
                            <td class="py-2 px-3">
                                <div class="flex items-center gap-2">
                                    @if($up->status !== 'cancelled')
                                        <form method="POST" action="{{ route('my-plans.cancel', $up) }}">
                                            @csrf
                                            <button type="submit" class="px-2 py-1 text-sm bg-red-500 text-white rounded">Cancel</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('my-plans.renew', $up) }}">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 text-sm bg-green-600 text-white rounded">Renew</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layouts.dashboard>
