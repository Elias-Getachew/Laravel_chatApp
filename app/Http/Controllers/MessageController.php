<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::all();
        $messages = Message::with('fromUser')->orderBy('created_at', 'asc')->get(); // Get messages in ascending order
        return view('messages.index', compact('messages','users'));
    }

  



    public function store(Request $request)
    {

        $request->validate([
            'message' => 'required|string',
            'to_user_id' => 'required|exists:users,id'
        ]);

        
        $message = new Message();
        $message->from_user_id = Auth::id();
        $message->to_user_id = $request->to_user_id;
        $message->message = $request->message;
        $message->save();

        return back()->with('success', 'Message sent successfully!');
    }
}
