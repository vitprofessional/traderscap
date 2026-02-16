<x-layouts.dashboard title="Dashboard">
    <div class="max-w-6xl w-full">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Welcome back, {{ $user->name ?? 'Customer' }}</h1>
                <p class="text-sm text-gray-600">Overview of your account and active plans.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('investment-plans') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">Browse Plans</a>
                <a href="{{ route('profile') }}" class="inline-flex items-center px-3 py-2 border border-gray-200 rounded-md text-sm">Account</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Active Plans</div>
                <div class="mt-2 text-2xl font-semibold">{{ $userPackages->where('status','active')->count() }}</div>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Next Expiry</div>
                @php
                    $next = $userPackages->where('status','active')->filter(fn($u)=> $u->ends_at)->sortBy('ends_at')->first();
                @endphp
                <div class="mt-2 text-lg">{{ $next && $next->ends_at ? $next->ends_at->toFormattedDateString() : '-' }}</div>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Email</div>
                <div class="mt-2 text-lg">{{ $user->email ?? '-' }}</div>
            </div>
        </div>

        @if($userPackages->isEmpty())
            <section class="bg-white p-6 rounded shadow">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <div class="w-12 h-12 flex items-center justify-center bg-indigo-50 rounded-full text-indigo-600">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 7v6a4 4 0 004 4h10a4 4 0 004-4V7" />
                            <path d="M16 3v4" />
                            <path d="M8 3v4" />
                        </svg>
                    </div>
                    <h2 class="text-center text-2xl font-semibold">Get started in 4 simple steps</h2>
                </div>
                <p class="text-center text-sm text-gray-600 mb-6">Follow these quick steps to begin investing with TradersCap.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    @php
                        $steps = [
                            ['title'=>'Open Trading Account','desc'=>'Open trading account with your preferred broker or choose from our reputed broker lists','icon_class'=>'fa-solid fa-briefcase'],
                            ['title'=>'Fund Your Account','desc'=>'After creating your account, fund your account to start trading.','icon_class'=>'fa-solid fa-wallet'],
                            ['title'=>'Send MT4 Details','desc'=>'When funding is completed, send us your MT4 details to trade on your behalf','icon_class'=>'fa-solid fa-circle-info'],
                            ['title'=>'Watch & Earn','desc'=>'You may watch and enjoy our profitable trading from anywhere','icon_class'=>'fa-solid fa-eye'],
                        ];
                    @endphp

                    @foreach($steps as $s)
                        <div class="p-4 rounded border bg-white">
                            <div class="flex items-center gap-6">
                                <div class="w-28 h-16 rounded-full border-2 border-indigo-900 flex items-center justify-center bg-white">
                                    <i class="{{ $s['icon_class'] }} text-indigo-900 text-2xl" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ $s['title'] }}</div>
                                    <div class="text-sm text-gray-600">{{ $s['desc'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-center gap-3">
                    <a href="{{ route('investment-plans') }}" class="px-5 py-3 bg-indigo-600 text-white rounded-md">Start Your Journey</a>
                    <a href="#" class="px-4 py-2 border rounded-md text-sm">Open Trading Account</a>
                </div>
            </section>
        @else
            <div class="bg-white p-4 rounded shadow">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-medium">Your Packages</h2>
                    <a href="{{ route('investment-plans') }}" class="text-sm text-indigo-600 hover:underline">Buy more plans</a>
                </div>

                <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b text-gray-600">
                            <th class="py-3 px-2">Package</th>
                            <th class="py-3 px-2">Starts</th>
                            <th class="py-3 px-2">Ends</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userPackages as $up)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-2">{{ $up->package->name ?? '—' }}</td>
                                <td class="py-3 px-2">{{ $up->starts_at ? $up->starts_at->toFormattedDateString() : '—' }}</td>
                                <td class="py-3 px-2">{{ $up->ends_at ? $up->ends_at->toFormattedDateString() : '—' }}</td>
                                <td class="py-3 px-2">{{ ucfirst($up->status) }}</td>
                                <td class="py-3 px-2 text-right">
                                    <a href="{{ route('my-plans') }}" class="text-sm text-indigo-600 hover:underline mr-3">Manage</a>
                                    @if($up->status === 'active')
                                        <form method="POST" action="{{ route('my-plans.cancel', $up) }}" class="inline" onsubmit="return confirm('Cancel this package?');">
                                            @csrf
                                            <button type="submit" class="text-sm text-red-600">Cancel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        @endif
    </div>
    <script>
        // small helper to stop accidental form double submits
        document.addEventListener('submit', function(e){
            const form = e.target;
            if(form.getAttribute('data-prevent-double')){
                const btn = form.querySelector('button[type=submit]');
                if(btn) btn.disabled = true;
            }
        });
    </script>
</x-layouts.dashboard>
