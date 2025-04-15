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
  