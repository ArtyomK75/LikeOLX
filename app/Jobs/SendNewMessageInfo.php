<?php

namespace App\Jobs;

use App\Mail\NewMessage;
use App\Models\Advert;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendNewMessageInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Message $message,
    )
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dialogue = $this->message->dialogue;
        $advert =$dialogue->advert;
        if ($this->message->user_id === $dialogue->user_id) {
            Mail::to($advert->user->email)->send(new NewMessage($this->message, $advert));
        } else {
            Mail::to($dialogue->user->email)->send(new NewMessage($this->message, $advert));
        }

    }
}
