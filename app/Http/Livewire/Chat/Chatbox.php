<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class Chatbox extends Component
{

    public $selectedConversation;
    public $receiver;
    public $messages;
    public $receiverInstance;
    public $messages_count;
    public $paginateVar = 10;
    public $height;

    protected $listeners = ['loadConversation',];
    //protected $listeners = ['loadConversation', 'pushMessage', 'loadmore', 'updateHeight', "echo-private:chat. {$auth_id},MessageSent" => 'broadcastedMessageReceived',];


    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance = null;
    }
    public function loadConversation(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation =  $conversation;
        $this->receiverInstance =  $receiver;


        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id',  $this->selectedConversation->id)
            ->skip($this->messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $this->dispatchBrowserEvent('chatSelected');

        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id', auth()->user()->id)->update(['read' => 1]);

        $this->emitSelf('broadcastMessageRead');
    }
    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
