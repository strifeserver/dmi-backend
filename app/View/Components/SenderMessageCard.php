<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SenderMessageCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public $timeStamp;
    public $content;
    public $attachments;
    public $image;
    public $type;
    public function __construct($name, $email, $timeStamp, $content, $attachments, $image, $type)
    {
        $this->name = $name;
        $this->email = $email;
        $this->timeStamp = $timeStamp;
        $this->content = $content;
        $this->attachments = $attachments;
        $this->image = $image;
        $this->type = $type;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sender-message-card');
    }
}
