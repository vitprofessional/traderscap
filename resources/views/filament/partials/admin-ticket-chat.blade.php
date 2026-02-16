@php
$ticket = \App\Models\Ticket::find($ticket_id);
@endphp

@if($ticket)
    <div id="admin-chat-messages" style="max-height:360px;overflow:auto;padding:0.5rem;border:1px solid #e5e7eb;border-radius:0.375rem;background:#fff;margin-bottom:1rem;">
        @foreach($ticket->messages()->orderBy('created_at')->get() as $m)
            <div style="margin-bottom:0.75rem;padding:0.5rem;border-radius:0.375rem; background: {{ $m->is_admin ? '#eef2ff' : '#f9fafb' }};">
                <div style="white-space:pre-wrap;color:#374151;font-size:0.875rem;">{!! nl2br(e($m->message)) !!}</div>
                @if($m->attachment)
                    <div style="margin-top:0.5rem;"><a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($m->attachment) }}" target="_blank" style="color:#4f46e5;text-decoration:underline;font-size:0.875rem;">View attachment</a></div>
                @endif
                <div style="font-size:0.75rem;color:#6b7280;margin-top:0.5rem;">{{ $m->created_at->diffForHumans() }} @if($m->user) • {{ $m->user->name }} @endif</div>
            </div>
        @endforeach
    </div>

    <div id="admin-reply-box" style="margin-top:0.5rem;">
        <div style="margin-bottom:0.75rem;">
            <textarea id="admin-reply-message" rows="3" style="width:100%;border:1px solid #e5e7eb;border-radius:0.375rem;padding:0.5rem;" placeholder="Write a message..."></textarea>
        </div>
        <div style="margin-bottom:0.75rem;">
            <input type="file" id="admin-reply-attachment" name="attachment" accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx" />
            <div id="admin-reply-fileinfo" style="margin-top:0.5rem;font-size:0.875rem;color:#6b7280;"></div>
        </div>
        <div>
            <button id="admin-reply-send" type="button" class="filament-button filament-button-size-md" style="background:#4f46e5;color:#fff;border-radius:0.375rem;padding:0.5rem 1rem;border:none;">Send</button>
            <span id="admin-reply-status" style="margin-left:0.5rem;font-size:0.875rem;color:#6b7280;"></span>
        </div>
    </div>

    <script>
        (function(){
            const btn = document.getElementById('admin-reply-send');
            const messageEl = document.getElementById('admin-reply-message');
            const attachmentEl = document.getElementById('admin-reply-attachment');
            const statusEl = document.getElementById('admin-reply-status');
            const ticketId = '{{ $ticket->id }}';
            const url = '{{ url('admin/tickets/'.$ticket->id.'/reply') }}';

            const fileInfoEl = document.getElementById('admin-reply-fileinfo');
            attachmentEl.addEventListener('change', function(){
                const f = this.files && this.files[0];
                if (!f) { fileInfoEl.textContent = ''; return; }
                const kb = Math.round(f.size/1024);
                fileInfoEl.textContent = f.name + ' ('+ kb + ' KB)';
            });

            btn.addEventListener('click', function(e){
                btn.disabled = true;
                statusEl.textContent = 'Sending...';
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('message', messageEl.value);
                if (attachmentEl.files && attachmentEl.files[0]) {
                    formData.append('attachment', attachmentEl.files[0]);
                }

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                }).then(async (res) => {
                    btn.disabled = false;
                    if (!res.ok) {
                        const txt = await res.text();
                        statusEl.textContent = 'Failed to send';
                        console.error('Admin reply failed', res.status, txt);
                        return;
                    }
                    // success - reload to show the new message
                    statusEl.textContent = 'Sent';
                    setTimeout(()=> location.reload(), 700);
                }).catch((err)=>{
                    btn.disabled = false;
                    statusEl.textContent = 'Failed to send';
                    console.error('Admin reply error', err);
                });
            });
        })();
    </script>
@else
    <div class="text-sm text-gray-600">Ticket not found.</div>
@endif
