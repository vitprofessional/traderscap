<div class="max-w-3xl w-full">

    <div class="bg-white p-4 rounded shadow mb-4 h-96 overflow-y-auto" wire:poll.3s id="chat-messages">
        @foreach($messages as $m)
            <div class="mb-3 p-3 rounded {{ $m->is_admin ? 'bg-indigo-50 text-indigo-900' : 'bg-gray-50' }}">
                <div class="text-sm text-gray-700">{!! nl2br(e($m->message)) !!}</div>
                @if($m->attachment)
                    <div class="mt-2">
                        <a href="{{ asset('storage/app/public/'.$m->attachment) }}" target="_blank" class="text-sm text-indigo-600 hover:underline">View attachment</a>
                    </div>
                @endif
                <div class="text-xs text-gray-500 mt-2">{{ $m->created_at->diffForHumans() }} @if($m->user) • {{ $m->user->name }} @endif</div>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage">
        <div class="mb-3">
            <textarea wire:model.defer="message" rows="3" class="w-full border rounded p-2" placeholder="Write a message..."></textarea>
        </div>
        <div class="mb-3">
            <input type="file" wire:model="attachment" accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx" />
            @error('attachment') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Send</button>
            <a href="{{ route('complaints') }}" class="px-4 py-2 border rounded">Back</a>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:load', function () {
            const container = document.getElementById('chat-messages');
            function scrollBottom() { container.scrollTop = container.scrollHeight; }
            scrollBottom();
            Livewire.hook('message.processed', (component) => {
                scrollBottom();
            });
            Livewire.on('ticketMessageSent', scrollBottom);
        });
    </script>

</div>
