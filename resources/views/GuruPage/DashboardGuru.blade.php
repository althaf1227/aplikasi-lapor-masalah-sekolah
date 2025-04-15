<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>halaman guru</h1>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
          Notifikasi
          @if(auth()->user()->unreadNotifications->count())
              <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
          @endif
        </a>
        <ul class="dropdown-menu">
          @forelse(auth()->user()->unreadNotifications as $notif)
            <li>
              <a class="dropdown-item" href="{{ route('guru.chat.show', $notif->data['conversation_id']) }}">
                  {{ $notif->data['text'] }}
              </a>
            </li>
          @empty
            <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
          @endforelse
        </ul>
      </li>

      <li><a class="nav-link" href="{{ route('guru.inbox') }}">📨 Inbox</a></li>
      
</body>
</html>