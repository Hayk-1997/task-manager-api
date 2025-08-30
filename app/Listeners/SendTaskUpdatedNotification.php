<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskUpdatedNotification implements ShouldQueue
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
    public function handle(TaskUpdated $event): void
    {
        Mail::raw(
            "Assigned Task has been updated: {$event->task->title}",
            function ($message) use ($event) {
                $message->to($event->user->email)
                    ->subject('Task Updated');
            }
        );
    }
}
