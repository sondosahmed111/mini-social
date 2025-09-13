<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // صفحة تعرض جميع المستخدمين
    public function users()
    {
        $users = User::where('id', '!=', Auth::id())->get(); // استبعاد نفسك
        return view('chat.users', compact('users'));
    }

    // صفحة الشات مع مستخدم محدد
    public function show($receiverId)
    {
        $receiver = User::findOrFail($receiverId);
    return view('chat.chat', compact('receiver'));    }

    // جلب الرسائل بين المستخدم الحالي والمستقبل
    public function messages($receiverId)
    {
        $receiver = User::findOrFail($receiverId);

$messages = Message::where(function($q) use ($receiver) {
        $q->where('sender_id', Auth::id())
          ->where('receiver_id', $receiver->id);
    })->orWhere(function($q) use ($receiver) {
        $q->where('sender_id', $receiver->id)
          ->where('receiver_id', Auth::id());
    })
    ->orderBy('created_at')
    ->get()
    ->map(function ($msg) {
        return [
            'id' => $msg->id,
            'sender_id' => $msg->sender_id,
            'receiver_id' => $msg->receiver_id,
            'message' => $msg->content,
            'created_at' => $msg->created_at->diffForHumans(),
        ];
    });

        return response()->json($messages);
    }

    // إرسال رسالة جديدة
public function send(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required|string|max:255',
    ]);

    $msg = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'content' => $request->message,
    ]);

    return response()->json([
        'id' => $msg->id,
        'sender_id' => $msg->sender_id,
        'receiver_id' => $msg->receiver_id,
        'message' => $msg->content,
        'created_at' => $msg->created_at->diffForHumans(),
    ]);
}

    // تعديل رسالة
    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $msg = Message::findOrFail($id);

        if ($msg->sender_id != Auth::id()) {
            abort(403);
        }

        $msg->update(['content' => $request->message]);

        return response()->json($msg);
    }

    // حذف رسالة
    public function delete($id)
    {
        $msg = Message::findOrFail($id);

        if ($msg->sender_id != Auth::id()) {
            abort(403);
        }

        $msg->delete();

        return response()->json(['success' => true]);
    }
}
