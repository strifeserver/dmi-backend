<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Http\Request; 
class MessageRows extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $contact;
    public $messageCount;
    public $content;
    public $updatedAt;
    public $conversationId;
    public function __construct($conversationId,$contact, $messageCount, $content, $updatedAt)
    {
        $this->conversationId = $conversationId;
        $this->contact = $contact;
        $this->messageCount = $messageCount;
        $this->content = $content;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.message-rows');
    }
}
