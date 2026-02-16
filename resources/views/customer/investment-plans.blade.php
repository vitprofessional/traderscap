<x-layouts.dashboard>
    <div>
        <h2 class="text-xl font-semibold mb-4">Investment Plans</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach($plans as $plan)
                <div class="p-4 bg-white rounded shadow">
                    <h3 class="font-medium">{{ $plan->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $plan->description }}</p>
                    <div class="mt-3 flex items-center justify-between">
                        <div class="text-lg font-semibold">${{ number_format($plan->price, 2) }}</div>
                        <form method="POST" action="{{ route('investment-plans.activate', $plan) }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded">Activate</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.dashboard>
