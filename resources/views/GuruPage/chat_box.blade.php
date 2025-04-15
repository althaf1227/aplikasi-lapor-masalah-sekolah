@extends('GuruPage.layouts.app')

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
                @if($isSender)
                    <small class="text-muted">{{ $msg->read_at ? 'Dibaca' : 'Terkirim' }}</small>
                @endif
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
        cluster: 'eu', // ganti sesuai cluster Pusher kamu
        forceTLS: false,
        encrypted: true,
        authEndpoint: "/broadcasting/auth",
        
    });

    console.log('📦 Loaded Chat View: ', {
        conversationId,
        currentUserId
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        console.log('✉️ Kirim pesan:', messageInput.value);

        fetch(`/guru/chat/${conversationId}/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: messageInput.value })
        })
        .then(res => res.json())
        .then(data => {
            console.log('✅ Response dari server:', data);
            messageInput.value = '';
            loadMessages();
        })
        .catch(err => {
            console.error('❌ Error kirim pesan:', err);
        });
    });

    // Real-time listener
    Echo.private(`chat.${conversationId}`)
        .listen('MessageSent', (e) => {
            console.log('📡 Dapet broadcast realtime:', e);

            if (e.sender_id !== currentUserId) {
                const incomingMsg = `
                    <div class="d-flex flex-column text-start mb-2">
                        <div class="px-3 py-2 rounded-3 bg-light text-dark me-auto">
                            <small><strong>${e.sender_name}</strong></small><br>
                            ${e.message}
                        </div>
                    </div>
                `;
                chatBox.innerHTML += incomingMsg;
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });

        
    // Load pesan via AJAX
    function loadMessages() {
        fetch(`/guru/chat/load/${conversationId}`)
            .then(res => res.json())
            .then(data => {
                chatBox.innerHTML = '';
                data.forEach(msg => {
                    const isSender = msg.sender_id == currentUserId;
                    const bubbleClass = isSender ? 'bg-primary text-white ms-auto' : 'bg-light text-dark me-auto';
                    const align = isSender ? 'text-end' : 'text-start';

                    const div = document.createElement('div');
                    div.classList.add('d-flex', 'flex-column', align, 'mb-2');
                    div.innerHTML = `
                        <div class="px-3 py-2 rounded-3 ${bubbleClass}" style="word-break: break-word;">
                            <small><strong>${msg.sender.nama}</strong></small><br>
                            ${msg.message}
                        </div>
                    `;
                    chatBox.appendChild(div);
                });

                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    if (window.isLoggedIn && window.currentConversationId) {
    const channel = window.Echo.private(`chat.${window.currentConversationId}`);

    channel.listen('NewMessage', (e) => {
        console.log('Pesan baru:', e);
        // tambahkan ke UI chat
    });

    channel.listen('MessageRead', (e) => {
        console.log('Pesan dibaca:', e);
        const messageElement = document.querySelector(`[data-message-id="${e.message_id}"]`);
        if (messageElement) {
            messageElement.classList.add('dibaca'); // atau tambahkan ikon "dibaca"
        }
    });
}

    // Load pertama kali
    loadMessages();

    // Polling cadangan tiap 5 detik
    setInterval(loadMessages, 1000);
</script>
@endsection


