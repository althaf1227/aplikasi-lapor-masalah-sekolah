@extends('GuruPage.layouts.app')

@section('content')
<div class="container">
    <h4>Inbox dari Siswa</h4>
    <ul class="list-group">
        @foreach($conversations as $conv)
            @php
                $unread = $conv->messages->where('sender_id', '!=', auth()->id())
                                        ->whereNull('read_at')
                                        ->count();
            @endphp
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('guru.chat.show', $conv->id) }}">
                    {{ $conv->siswa->nama }}
                </a>
                @if($unread > 0)
                    <span class="badge bg-danger">{{ $unread }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
