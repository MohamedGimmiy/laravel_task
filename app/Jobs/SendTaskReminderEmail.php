<?php

namespace App\Jobs;

use App\Mail\TaskReminderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskReminderEmail implements ShouldQueue
{
       use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        Mail::to($this->task->user->email)->send(new TaskReminderMail($this->task));
    }
}
