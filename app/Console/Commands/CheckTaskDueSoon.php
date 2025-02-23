<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckTaskDueSoon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-task-due-soon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = \App\Models\Task::whereBetween('due_date', [now(), now()->addDay()])->get();

        foreach ($tasks as $task) {
            // Notifica o criador
            $task->creator->notify(new \App\Notifications\TaskDueSoon($task));

            // Notifica os demais usuários vinculados (exceto o criador)
            $task->users->each(function($user) use ($task) {
                if ($user->id !== $task->created_by) {
                    $user->notify(new \App\Notifications\TaskDueSoon($task));
                }
            });
        }
    }

}
