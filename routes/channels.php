<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversations;

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversations::find($conversationId);

    if (!$conversation) return false;

    // Cek apakah user adalah pengirim atau penerima
    return $conversation &&
        ($conversation->guru_id === $user->id || $conversation->siswa_id === $user->id);
});
