<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Jobs\SendTaskDueNotification;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for tasks due tomorrow';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow();

        $tasks = Task::whereDate('deadline', $tomorrow)
                     ->where('status', '!=', TaskStatus::DONE)
                     ->get();

        foreach ($tasks as $task) {
            SendTaskDueNotification::dispatch($task);
        }

        $this->info("Scheduled notifications for {$tasks->count()} tasks.");
    }
}
