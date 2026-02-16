<x-layouts.app :title="$title ?? 'TradersCap'">

<div class="min-h-screen flex bg-gray-50">
    <aside id="sidebar" class="w-64 bg-indigo-600 text-white shadow-sm hidden md:block">
        <div class="p-4 border-b border-indigo-700 flex items-center justify-between">
            <h2 class="text-lg font-semibold">TradersCap</h2>
            <button id="sidebar-close" class="md:hidden text-white">✕</button>
        </div>

        <nav class="p-4">
            <ul class="space-y-1">
                @php
                    $items = [
                        ['route'=>'dashboard','label'=>'Dashboard','icon'=>'home'],
                        ['route'=>'my-plans','label'=>'My Plans','icon'=>'collection'],
                        ['route'=>'investment-plans','label'=>'Investment Plans','icon'=>'credit-card'],
                        ['route'=>'complaints','label'=>'Complaints','icon'=>'chat'],
                        ['route'=>'partners','label'=>'Partners Corner','icon'=>'users'],
                        ['route'=>'profile','label'=>'Profile','icon'=>'user'],
                    ];
                @endphp

                @foreach($items as $it)
                    @php
                        $isActive = request()->routeIs($it['route'].'*');
                        $routeUrl = route($it['route']);
                    @endphp

                    <li>
                        <a href="{{ $routeUrl }}" class="group flex items-center gap-3 p-2 rounded-md transition-colors duration-150 {{ $isActive ? 'bg-white/10 text-white' : 'text-white/90 hover:bg-white/5' }}">
                            <span class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $isActive ? 'bg-white text-indigo-600' : 'bg-white/5 text-white' }}">
                                @if($it['icon'] === 'home')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.5z"/></svg>
                                @elseif($it['icon'] === 'collection')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7a2 2 0 012-2h14v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                                @elseif($it['icon'] === 'credit-card')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="5" width="18" height="12" rx="2"/></svg>
                                @elseif($it['icon'] === 'chat')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12c0 4.418-4.03 8-9 8-1.224 0-2.387-.2-3.44-.58L3 20l1.58-4.56C3.97 14.39 3 13.25 3 12V7a2 2 0 012-2h14a2 2 0 012 2v5z"/></svg>
                                @elseif($it['icon'] === 'users')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM6 11c1.657 0 3-1.343 3-3S7.657 5 6 5 3 6.343 3 8s1.343 3 3 3zM6 13c-2.33 0-7 1.17-7 3.5V20h14v-3.5C13 14.17 8.33 13 6 13z"/></svg>
                                @elseif($it['icon'] === 'user')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-9 9a9 9 0 0118 0v1H3v-1z"/></svg>
                                @endif
                            </span>

                            <span class="font-medium">{{ $it['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="flex items-center justify-between p-4 bg-white border-b">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="md:hidden px-2 py-1 border rounded">☰</button>
                <h3 class="text-lg font-medium">{{ $title ?? 'Dashboard' }}</h3>
            </div>

            <div class="flex items-center gap-4">
                @php $u = auth()->user(); @endphp
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full overflow-hidden">
                        @if($u && isset($u->avatar))
                            <img src="{{ $u->avatar }}" alt="avatar" class="w-full h-full object-cover">
                        @else
                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($u->email ?? '')) ) }}?s=80&d=identicon" alt="avatar" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="text-sm text-indigo-900">
                        <div class="font-medium">{{ $u->name ?? 'Guest' }}</div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-indigo-700 hover:underline">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-6 bg-gray-50 flex-1 overflow-auto">
            {{ $slot }}
        </main>
    </div>

    <script>
        (function(){
            var toggle = document.getElementById('sidebar-toggle');
            var sidebar = document.getElementById('sidebar');
            var closeBtn = document.getElementById('sidebar-close');
            if(toggle && sidebar){
                toggle.addEventListener('click', function(){
                    sidebar.classList.toggle('hidden');
                });
            }
            if(closeBtn && sidebar){
                closeBtn.addEventListener('click', function(){
                    sidebar.classList.add('hidden');
                });
            }
        })();
    </script>
    </div>

</x-layouts.app>
