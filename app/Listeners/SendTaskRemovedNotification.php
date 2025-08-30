<?php

namespace App\Listeners;

use App\Events\TaskRemoved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskRemovedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskRemoved $event): void
    {
        Mail::raw(
            "Assigned Task has been removed: {$event->task->title}",
            function ($message) use ($event) {
                $message->to($event->user->email)
                    ->subject('Task removed');
            }
        );
    }
}
