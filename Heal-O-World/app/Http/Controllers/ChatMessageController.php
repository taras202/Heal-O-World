<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Events\NewMessageSent;

class ChatMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|integer|exists:chats,id',
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create([
            'chat_id' => $validated['chat_id'],
            'sender_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        NewMessageSent::dispatch(
            $message->chat_id,
            $message->message,
            $message->sender_id
        );

        return response()->json(['status' => 'Message sent']);
    }
}
