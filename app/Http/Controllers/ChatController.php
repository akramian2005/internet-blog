<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // --- Пользователь: список своих тикетов ---
    public function userTickets()
    {
        $tickets = Ticket::where('user_id', Auth::id())
                         ->orderBy('status', 'asc')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('chat.user_tickets', compact('tickets'));
    }

    // --- Создание новой заявки ---
    public function createTicket(Request $request)
    {
        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => 'Техническая поддержка',
            'status' => 'open',
        ]);

        return redirect()->route('chat.chat', $ticket->id);
    }

    // --- Просмотр конкретного чата пользователя ---
    public function chat($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $messages = $ticket->messages()->orderBy('created_at')->get();

        return view('chat.index', compact('ticket', 'messages'));
    }

    // --- Отправка сообщения ---
public function send(Request $request, $ticketId)
{
    $request->validate(['message' => 'required|string']);

    $ticket = Ticket::findOrFail($ticketId);

    $receiverId = Auth::user()->is_admin 
                  ? $ticket->user_id 
                  : User::where('is_admin', true)->first()->id;

    Message::create([
        'ticket_id' => $ticket->id,
        'user_id' => Auth::id(),
        'receiver_id' => $receiverId,
        'message' => $request->message,
    ]);

    return back();
}


    // --- Закрытие тикета пользователем ---
    public function closeTicket($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $ticket->update(['status' => 'closed']);

        return back();
    }

    // --- Закрытие тикета админом ---
    public function adminCloseTicket($ticketId)
    {
        if (!Auth::user()->is_admin) abort(403);

        Ticket::where('id', $ticketId)->update(['status' => 'closed']);
        return back();
    }

    // --- Админ: список всех тикетов ---
    public function adminIndex()
    {
        if (!Auth::user()->is_admin) abort(403);

        $tickets = Ticket::orderBy('status', 'asc')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('chat.admin_index', compact('tickets'));
    }

    // --- Админ: чат с конкретной заявкой ---
    public function adminChat($ticketId)
    {
        if (!Auth::user()->is_admin) abort(403);

        $ticket = Ticket::findOrFail($ticketId);
        $messages = $ticket->messages()->orderBy('created_at')->get();

        return view('chat.admin_chat', compact('messages', 'ticket'));
    }
}
