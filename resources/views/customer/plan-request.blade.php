<x-layouts.dashboard>
    <div class="max-w-3xl w-full mx-auto">
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-4xl font-semibold text-green-600 uppercase tracking-wide">Membership Plan</h2>
                <p class="mt-2 text-xl">
                    <span class="font-semibold">Account Status:</span>
                    {{ $latestStatus ? ucfirst($latestStatus) : 'No Plan' }}
                </p>
            </div>

            <form method="POST" action="{{ route('investment-plans.request.submit', $selectedPackage) }}" class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Broker Name</label>
                    <input
                        type="text"
                        name="broker_name"
                        value="{{ old('broker_name', $existingPackage?->broker_name) }}"
                        placeholder="Enter broker name"
                        class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                    @error('broker_name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trading ID</label>
                    <input
                        type="text"
                        name="trading_id"
                        value="{{ old('trading_id', $existingPackage?->trading_id) }}"
                        placeholder="Enter MT4/MT5 trading ID"
                        class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                    @error('trading_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trading Password</label>
                    <input
                        type="text"
                        name="trading_password"
                        value="{{ old('trading_password', $existingPackage?->trading_password) }}"
                        placeholder="Enter MT4/MT5 trading password"
                        class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                    @error('trading_password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trading Server</label>
                    <input
                        type="text"
                        name="trading_server"
                        value="{{ old('trading_server', $existingPackage?->trading_server) }}"
                        placeholder="Enter trading server name"
                        class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                    @error('trading_server')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trading Package</label>
                    <select
                        name="package_id"
                        class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                        @foreach($planOptions as $id => $name)
                            <option value="{{ $id }}" @selected((int) old('package_id', $selectedPackage->id) === (int) $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('package_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Equity</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="equity"
                        value="{{ old('equity', $existingPackage?->equity) }}"
                        placeholder="Enter your account equity"
                        class="w-full rounded-md border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    @error('equity')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-5 py-2.5 rounded-md bg-green-600 text-white text-sm font-semibold hover:bg-green-700">
                        Submit Request
                    </button>
                    <a href="{{ route('investment-plans') }}" class="px-5 py-2.5 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
