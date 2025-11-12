<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Пользователь видит свой чат с админом
    public function index()
    {
        $messages = Message::where(function ($q) {
                $q->where('user_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        return view('chat.index', compact('messages'));
    }

    // Отправка сообщения (и пользователем, и админом)
    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $receiverId = Auth::user()->is_admin
            ? $request->receiver_id // если админ — он указывает кому
            : User::where('is_admin', true)->first()->id; // обычный пользователь → админу

        Message::create([
            'user_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        return back();
    }

    // Страница списка всех чатов (для админа)
    public function adminIndex()
    {
        if (!Auth::user()->is_admin) abort(403);

        $users = User::whereHas('sentMessages', function ($q) {
            $q->where('receiver_id', Auth::id());
        })->get();

        return view('chat.admin_index', compact('users'));
    }

    // Чат с конкретным пользователем
    public function adminChat($userId)
    {
        if (!Auth::user()->is_admin) abort(403);

        $messages = Message::where(function ($q) use ($userId) {
                $q->where('user_id', $userId)->where('receiver_id', Auth::id());
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('user_id', Auth::id())->where('receiver_id', $userId);
            })
            ->orderBy('created_at')
            ->get();

        $user = User::findOrFail($userId);

        return view('chat.admin_chat', compact('messages', 'user'));
    }
}

