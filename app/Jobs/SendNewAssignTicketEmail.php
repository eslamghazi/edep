<?php

namespace App\Jobs;

use App\Notifications\NewAssignTicketEmail;
use App\Notifications\NewTicketEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendNewAssignTicketEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;
    public $emails;
    public $ticket;

    public function __construct($emails, $ticket)
    {
        $this->emails = $emails;
        $this->ticket = $ticket;
//        dd( $this->ticket);
    }

    public function handle()
    {
        $notification = new NewAssignTicketEmail($this->ticket);

        foreach ($this->emails as $recipient) {
            Notification::route('mail', $recipient)->notify($notification);
        }
    }
}
