<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getMessages(Request $request)
    {
        $user = Auth::user();
        $messages = Chat::where('sender_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();


        return ResponseFormatter::success($messages, 'Messages retrieved');
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $request->input('message');
        $recipient = $request->input('recipient');
        $reply_id = $request->input('reply_id');

        $chat = Chat::create([
            'sender_id' => $user->id,
            'recipient_id' => $recipient,
            'message' => $message,
            'reply_id' => $reply_id
        ]);

        return ResponseFormatter::success([
            'message' => $chat
        ], 'Message sent successfully');
    }


}
