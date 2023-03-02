<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class CreateChat extends Component
{
    public $users;


    public function checkconversation($receiverId)
    {
        $checkedConversation = Conversation::where('receiver_id', auth()->user()->id)->where('sender_id', $receiverId)->orWhere('receiver_id', $receiverId)->where('sender_id', auth()->user()->id)->get();
        if (count($checkedConversation) == 0) {
            $createdConversation = Conversation::create([
                'receiver_id' => $receiverId,
                'sender_id' => auth()->user()->id,
                'last_time_message' => now(),
            ]);
            $createdMesssage = Message::create([
                'conversation_id' => $createdConversation->id,
                'sender_id' => auth()->user()->id,
                'receiver_id' => $receiverId,
                'body' => 'Hey, how are you?',
            ]);
            $createdConversation->last_time_message = $createdMesssage->created_at;
            $createdConversation->save();
        } else {
            dd('conversation exists');
        }
    }
    public function render()
    {
        $this->users = User::where('id', '!=', auth()->user()->id)->get();
        return view('livewire.chat.create-chat');
    }
}
