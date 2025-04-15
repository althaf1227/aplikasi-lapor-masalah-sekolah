<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use App\Events\MessageSent;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatGuruController extends Controller
{
    public function showChat($conversationId)
    {
        $conversation = Conversations::with(['siswa', 'messages.sender'])->findOrFail($conversationId);
        

        // Cek apakah guru adalah bagian dari percakapan ini
        if ($conversation->guru_id !== Auth::id()) {
            abort(403);
        }

        return view('GuruPage.chat_box', compact('conversation'));
    }

    public function sendMessage(Request $request, $id)
    {
        
        $conversation = Conversations::findOrFail($id);

        // Cek apakah user yang login adalah guru dalam conversation ini
        if ($conversation->guru_id !== Auth::id()) {
            abort(403);
        }
    
        $request->validate([
            'message' => 'required|string'
        ]);
    
        $message = messages::create([
            'conversation_id' => $id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false,
        ]);
    
        broadcast(new MessageSent($message))->toOthers();
        $message = Messages::with('sender')->find($message->id);
    
        return response()->json(['success' => true, 'message' => $message]);
    
    }
    public function loadMessages($conversationId)
    {
        $messages = Messages::where('conversation_id', $conversationId)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    // public function chatWithSiswa($siswaId)
    // {
    //     $guruId = auth()->id();

    //     $conversation = conversations::firstOrCreate([
    //         'guru_id' => $guruId,
    //         'siswa_id' => $siswaId,
    //     ]);

    //     $messages = $conversation->messages()->with('sender')->get();

    //     // tandai pesan sebagai dibaca
    //     $conversation->messages()
    //         ->where('sender_id', '!=', auth()->id())
    //         ->whereNull('read_at')
    //         ->update(['read_at' => now()]);

    //     return view('GuruPage.chat.chat_box', compact('conversation', 'messages'));
    // }

}

