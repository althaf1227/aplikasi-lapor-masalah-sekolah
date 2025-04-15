<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\MessageSent;
use App\Models\conversations;
use App\Models\messages;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageRead;


class ChatSiswaController extends Controller
{
    // 1. Tampilkan daftar guru
    public function listGuru()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('SiswaPage.list_guru', compact('gurus'));
    }

    // 2. Masuk ke chat dengan guru tertentu
    public function chatWithGuru($guruId)
    {
        $siswaId = Auth::id();

        $conversation = conversations::firstOrCreate(
            ['siswa_id' => $siswaId, 'guru_id' => $guruId]
        );

        $messages = $conversation->messages()->with('sender')->get();

        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);


        return view('SiswaPage.chat.chat_box', compact('conversation', 'messages'));
    }

    // 3. Kirim pesan
    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = messages::create([
            'conversation_id' => $conversationId,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function loadMessages($conversationId)
    {
        $messages = Messages::where('conversation_id', $conversationId)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    

}
