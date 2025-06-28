<?php

namespace App\Console\Commands;

use App\Jobs\SendTaskReminderEmail;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send task reminder emails 24 hours before due date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = Carbon::tomorrow();

        Task::where('is_sent', false)
            ->whereDate('due_date', $targetDate)
            ->with('user')
            ->get()
            ->each(function ($task) {
                dispatch(new SendTaskReminderEmail($task));

                // Mark task as sent
                $task->is_sent = true;
                $task->save();
            });

        $this->info('Reminder emails dispatched and tasks marked as sent.');
    }
}
