<?php

namespace App\Listeners;

use App\Events\EventMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
class SendEventMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  EventMail  $event
     * @return void
     */
    public function handle(EventMail $event)
    {
        $data = $event->data;
        $sendMail = Mail::send('emailer.eventmail', $data, function($message) use ($data) {
            $message->from('acma@acma.in');
            $message->to($data['to_emails']);

            $message->subject($data['subject']);

            // if(!empty($user['cc_emails'])) {
            //     $cc_emails = explode(',',$user['cc_emails']);
            //     $message->cc($cc_emails);
            // }
            // if(!empty($user['bcc_emails'])) {
            //     $bcc_emails = explode(',',$user['bcc_emails']);
            //     $message->bcc($bcc_emails);
            // }
        });
        echo "=><br><hr>";
        echo json_encode($sendMail);
        echo "<br><hr>=>";
    }
}
