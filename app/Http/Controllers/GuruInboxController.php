<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use Illuminate\Support\Facades\Auth;

class GuruInboxController extends Controller
{
    public function index()
    {
        $conversations = Conversations::with(['siswa', 'messages' => function ($q) {
            $q->latest();
        }])
        ->where('guru_id', Auth::id())
        ->get();

        return view('GuruPage.inbox', compact('conversations'));
    }
}
