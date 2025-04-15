@extends('SiswaPage.layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Guru BK</h3>
    <ul class="list-group mt-3">
        @foreach ($gurus as $guru)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $guru->nama }}
                <a href="{{ route('chat.with', $guru->id) }}" class="btn btn-primary btn-sm">Chat</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
