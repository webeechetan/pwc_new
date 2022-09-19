<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailFromJob extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $body;
    public $sub;
    public $files;
    public function __construct($body,$sub,$files)
    {
        $this->body = $body;
        $this->sub = $sub;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject($this->sub)->view('emailer.eventmail',['body'=>$this->body]);
                foreach($this->files as $file){
                    $email->attach($file);
                }
        return $email;
    }
}
