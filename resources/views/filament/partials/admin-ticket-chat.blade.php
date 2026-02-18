@php
    $ticket = \App\Models\Ticket::find($ticket_id);
@endphp

@if($ticket)
    <div id="admin-chat-wrapper" class="admin-chat-wrapper">

        <style>
        /* Fallback styles so chat looks correct even if Tailwind isn't available */
        .admin-chat-wrapper{max-width:920px;margin:0 auto;padding:1.5rem}
        .admin-chat-card{background:#fff;border-radius:10px;box-shadow:0 8px 22px rgba(15,23,42,0.07);overflow:hidden}
        .admin-chat-header{padding:16px 20px;border-bottom:1px solid #eef2f6;background:#fbfbfd;display:flex;justify-content:space-between;align-items:center}
        .admin-chat-body{padding:20px;height:60vh;overflow:auto;background:#ffffff}
        .admin-msg-row{display:flex;margin-bottom:10px}
        .admin-msg-row.end{justify-content:flex-end}
        .admin-msg-bubble{padding:14px 16px;border-radius:14px;display:inline-block;max-width:72%}
        .admin-msg-bubble.user{background:#f8fafc;color:#0f172a}
        .admin-msg-bubble.admin{background:#4f46e5;color:#fff}
        .admin-chat-input{padding:16px 20px;border-top:1px solid #eef2f6;background:#fbfbfd;display:flex;gap:14px;align-items:flex-end}
        .admin-chat-input textarea{flex:1;padding:12px;border:1px solid #e6e9ef;border-radius:10px;min-height:72px}
        .admin-chat-input .btn{background:#4f46e5;color:#fff;padding:10px 16px;border-radius:10px;border:none;cursor:pointer}
        .admin-chat-attach{font-size:13px;color:#374151}
        @media(max-width:640px){.admin-chat-wrapper{padding:12px}.admin-chat-body{height:48vh}}
        </style>

        <div class="admin-chat-card">
            <div class="admin-chat-header">
                <div>
                    <div class="text-sm font-medium">Ticket #{{ $ticket->id ?? '' }}</div>
                    <div class="text-xs text-gray-500">{{ $ticket->subject ?? 'No subject' }}</div>
                </div>
                <div class="text-sm text-gray-600">Status: <span class="font-medium">{{ ucfirst($ticket->status ?? 'open') }}</span></div>
            </div>

            <div id="admin-chat-messages" class="admin-chat-body bg-white">
                @foreach($ticket->messages()->orderBy('created_at')->get() as $m)
                    @php $isAdmin = $m->is_admin ?? ($m->admin_id ? true : false); @endphp
                    <div class="admin-msg-row {{ $isAdmin ? 'end' : '' }}">
                        <div>
                            @if(!$isAdmin)
                                <div style="width:36px;height:36px;border-radius:9999px;background:#eef2f6;display:inline-flex;align-items:center;justify-content:center;margin-right:8px;font-weight:600;color:#0f172a">{{ strtoupper(substr($m->user?->name ?? 'C',0,1)) }}</div>
                            @endif
                            <div class="admin-msg-bubble {{ $isAdmin ? 'admin' : 'user' }}">{!! nl2br(e($m->message)) !!}
                                @if($m->attachment)
                                    <div style="margin-top:8px;font-size:13px"><a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($m->attachment) }}" target="_blank" style="color:#4f46e5;text-decoration:underline">View attachment</a></div>
                                @endif
                            </div>
                            <div style="font-size:12px;color:#6b7280;margin-top:6px;">{{ $m->created_at->diffForHumans() }} @if(!$isAdmin && $m->user) • {{ $m->user->name }} @endif</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="admin-chat-input">
                <form id="admin-reply-form" action="{{ route('admin.tickets.reply', ['ticket' => $ticket->id]) }}" method="POST" enctype="multipart/form-data" style="display:flex;gap:12px;align-items:flex-end;width:100%">
                    @csrf
                    <textarea id="admin-reply-message" name="message" placeholder="Write a message..." style="flex:1;border-radius:8px;border:1px solid #e6e9ef;padding:10px;min-height:60px"></textarea>
                        <div style="display:flex;flex-direction:column;gap:8px;align-items:flex-end">
                        <div style="display:flex;gap:8px;align-items:center">
                            <label class="admin-chat-attach" title="Attach file" style="cursor:pointer;padding:8px 10px;border-radius:8px;background:#fff;border:1px solid #e6e9ef;display:inline-flex;align-items:center;gap:8px">
                                <span class="icon attach-icon" aria-hidden="true">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05L12.6 19.9a4.5 4.5 0 01-6.36-6.36l8.84-8.84a3.5 3.5 0 014.95 4.95L11.2 18.3a2 2 0 01-2.83-2.83l8.49-8.49"/></svg>
                                </span>
                                <span class="text-sm" style="font-size:13px;color:#374151">Attach</span>
                                <input id="admin-reply-attachment" type="file" name="attachment" style="display:none" />
                            </label>

                            <button id="icon-style-toggle" title="Toggle icon style" type="button" style="background:#fff;border:1px solid #e6e9ef;padding:8px;border-radius:8px;display:inline-flex;align-items:center">
                                <span class="icon-toggle" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                                </span>
                            </button>
                        </div>

                        <div style="display:flex;flex-direction:column;align-items:flex-end">
                            <button id="admin-reply-send" type="button" class="btn" style="display:inline-flex;align-items:center;gap:8px">
                                <span class="icon send-icon" aria-hidden="true">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20 1-7 7-7z"/></svg>
                                </span>
                                <span>Send</span>
                            </button>
                            <div id="admin-reply-fileinfo" class="text-sm text-gray-500 mt-2"></div>
                            <div id="admin-reply-status" class="text-sm text-gray-500 mt-1"></div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <script>
        (function(){
            const btn = document.getElementById('admin-reply-send');
            const messageEl = document.getElementById('admin-reply-message');
            const attachmentEl = document.getElementById('admin-reply-attachment');
            const statusEl = document.getElementById('admin-reply-status');
            const fileInfoEl = document.getElementById('admin-reply-fileinfo');
            const messagesUrl = '{{ url('admin/tickets/'.$ticket->id.'/messages') }}';
            const postUrl = '{{ url('admin/tickets/'.$ticket->id.'/reply') }}';

            function escapeHtml(unsafe) {
                return (unsafe||'')
                  .replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/\"/g, "&quot;")
                  .replace(/'/g, "&#039;");
            }

            function renderMessages(list) {
                const container = document.getElementById('admin-chat-messages');
                let html = '';
                list.forEach(m => {
                    const isAdmin = m.is_admin ? true : false;
                    const rowClass = isAdmin ? 'end' : '';
                    const bubbleClass = isAdmin ? 'admin' : 'user';
                    const attachment = m.attachment ? `<div style="margin-top:8px;font-size:13px"><a href="${m.attachment}" target="_blank" style="color:#4f46e5;text-decoration:underline">View attachment</a></div>` : '';
                    html += `<div class="admin-msg-row ${rowClass}"><div><div class="admin-msg-bubble ${bubbleClass}">${escapeHtml(m.message).replace(/\n/g,'<br/>')}${attachment}</div><div style="font-size:12px;color:#6b7280;margin-top:6px">${escapeHtml(m.diff)} ${m.author ? '• ' + escapeHtml(m.author) : ''}</div></div></div>`;
                });
                container.innerHTML = html;
                container.scrollTop = container.scrollHeight;
            }

            async function fetchLatestMessages(){
                try{
                    const res = await fetch(messagesUrl, { credentials: 'same-origin' });
                    if (!res.ok) return;
                    const data = await res.json();
                    renderMessages(data.messages || []);
                } catch (e) {
                    console.error('Failed fetching messages', e);
                }
            }

            attachmentEl.addEventListener('change', function(){
                const f = this.files && this.files[0];
                if (!f) { fileInfoEl.textContent = ''; return; }
                const kb = Math.round(f.size/1024);
                fileInfoEl.textContent = f.name + ' ('+ kb + ' KB)';
            });

            btn.addEventListener('click', async function(e){
                btn.disabled = true;
                statusEl.textContent = 'Sending...';
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('message', messageEl.value || '');
                if (attachmentEl.files && attachmentEl.files[0]) {
                    formData.append('attachment', attachmentEl.files[0]);
                }

                try{
                    const res = await fetch(postUrl, { method: 'POST', body: formData, credentials: 'same-origin' });
                    if (!res.ok) throw new Error('Request failed');
                    messageEl.value = '';
                    attachmentEl.value = '';
                    fileInfoEl.textContent = '';
                    statusEl.textContent = 'Sent';
                    setTimeout(()=> statusEl.textContent = '', 2000);
                    fetchLatestMessages();
                } catch (err) {
                    console.error(err);
                    statusEl.textContent = 'Failed to send';
                } finally {
                    btn.disabled = false;
                }
            });

            setInterval(fetchLatestMessages, 3000);
            setTimeout(fetchLatestMessages, 500);
        })();
        // Icon style toggle (outline / filled)
        (function(){
            const wrapper = document.getElementById('admin-chat-wrapper');
            const toggle = document.getElementById('icon-style-toggle');
            function setFilled(state){
                if(state){ wrapper.classList.add('icon-style-filled'); localStorage.setItem('chatIconFilled','1'); }
                else { wrapper.classList.remove('icon-style-filled'); localStorage.removeItem('chatIconFilled'); }
            }
            if(toggle && wrapper){
                const saved = localStorage.getItem('chatIconFilled');
                setFilled(!!saved);
                toggle.addEventListener('click', function(){ setFilled(!wrapper.classList.contains('icon-style-filled')); });
            }
        })();
    </script>
@else
    <div class="text-sm text-gray-600">Ticket not found.</div>
@endif
