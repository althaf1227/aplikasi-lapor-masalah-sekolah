@extends('SiswaPage.layouts.app')

@section('content')
<div class="container">
    <h4>Chat dengan {{ $conversation->siswa->nama }}</h4>

    <div id="chat-box" class="border p-3 mb-3" style="height: 300px; overflow-y: auto; background: #f8f9fa;">
        @foreach($conversation->messages as $msg)
            @php $isSender = $msg->sender_id === auth()->id(); @endphp
            <div class="d-flex flex-column {{ $isSender ? 'text-end' : 'text-start' }} mb-2">
                <div class="px-3 py-2 rounded-3 {{ $isSender ? 'bg-primary text-white ms-auto' : 'bg-light text-dark me-auto' }}">
                    <small><strong>{{ $msg->sender->nama }}</strong></small><br>
                    {{ $msg->message }}
                </div>
                @foreach ($messages as $msg)
                    <div class="pesan @if($msg->read_at) dibaca @endif" data-message-id="{{ $msg->id }}">
                        {{ $msg->isi }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <form id="chat-form">
        @csrf
        <div class="input-group">
            <input type="text" id="message" class="form-control" placeholder="Tulis pesan...">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

<script>
    const chatBox = document.getElementById('chat-box');
    const form = document.getElementById('chat-form');
    const messageInput = document.getElementById('message');
    const conversationId = {{ $conversation->id }};
    const currentUserId = {{ auth()->id() }};

    Pusher.logToConsole = true;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '55e51002f8da6944bfc3',
        cluster: 'eu',
        forceTLS: false,
        encrypted: true,
        authEndpoint: "/broadcasting/auth",
        auth: {
            withCredentials: true
        }
    });

    // Kirim pesan
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(`/siswa/chat/send/${conversationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: messageInput.value })
        }).then(() => {
            messageInput.value = '';
            loadMessages();
        });
    });

    // Real-time menerima pesan
    Echo.private(`chat.${conversationId}`)
        .listen('MessageSent', (e) => {
            const isFromGuru = e.sender_id !== currentUserId && e.sender_id !== null;

            // Jika pesan dari guru, hapus auto-reply
            if (isFromGuru) {
                const autoReply = document.querySelector('.auto-reply');
                if (autoReply) {
                    autoReply.remove();
                }
            }

            // Tampilkan pesan
            const bubbleClass = e.sender_id === null
                ? 'bg-warning text-dark auto-reply'
                : (e.sender_id === currentUserId ? 'bg-primary text-white ms-auto' : 'bg-light text-dark me-auto');

            const align = e.sender_id === currentUserId
                ? 'text-end'
                : 'text-start';

            const div = document.createElement('div');
            div.classList.add('d-flex', 'flex-column', align, 'mb-2');
            if (e.sender_id === null) {
                div.classList.add('auto-reply');
            }

            div.innerHTML = `
                <div class="px-3 py-2 rounded-3 ${bubbleClass}" style="word-break: break-word;">
                    <small><strong>${e.sender_name || 'System'}</strong></small><br>
                    ${e.message}
                </div>
            `;

            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
        })

        .listen('MessageRead', (e) => {
            console.log('Pesan dibaca:', e);
            const messageElement = document.querySelector(`[data-message-id="${e.message_id}"]`);
            if (messageElement) {
                messageElement.classList.add('dibaca');
            }
        });

    // Load pesan via AJAX
    function loadMessages() {
        fetch(`/siswa/chat/load/${conversationId}`)
            .then(res => res.json())
            .then(data => {
                chatBox.innerHTML = '';
                data.forEach(msg => {
                    const isSender = msg.sender_id == currentUserId;
                    const bubbleClass = msg.sender_id === null
                        ? 'bg-warning text-dark auto-reply'
                        : (isSender ? 'bg-primary text-white ms-auto' : 'bg-light text-dark me-auto');

                    const align = isSender
                        ? 'text-end'
                        : 'text-start';

                    const div = document.createElement('div');
                    div.classList.add('d-flex', 'flex-column', align, 'mb-2');
                    if (msg.sender_id === null) {
                        div.classList.add('auto-reply');
                    }

                    div.innerHTML = `
                        <div class="px-3 py-2 rounded-3 ${bubbleClass}" style="word-break: break-word;">
                            <small><strong>${msg.sender?.nama || 'System'}</strong></small><br>
                            ${msg.message}
                        </div>
                    `;
                    chatBox.appendChild(div);
                });

                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    // Load pertama kali
    loadMessages();

    // Polling cadangan tiap 1 detik (opsional)
    setInterval(loadMessages, 1000);
</script>

@endsection


