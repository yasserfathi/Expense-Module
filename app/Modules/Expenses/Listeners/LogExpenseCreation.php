<?php

namespace App\Modules\Expenses\Listeners;

use App\Modules\Expenses\Events\ExpenseCreated;
use App\Modules\Expenses\Notifications\ExpenseCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class LogExpenseCreation implements ShouldQueue
{
    public function handle(ExpenseCreated $event): void
{
    // Always log the creation first
    Log::channel('expenses')->info($event->logMessage, [
        'id' => $event->expense->id,
        'title' => $event->expense->title
    ]);

    // Skip notifications if no user or not configured
    if (!config('expenses.notifications.database') || !$event->expense->user_id) {
        return;
    }

    try {
        // Ensure user relationship is loaded
        if (!$event->expense->relationLoaded('user')) {
            $event->expense->load('user');
        }

        // Final null check
        if ($event->expense->user) {
            $event->expense->user->notify(
                new ExpenseCreatedNotification($event->expense, 'database')
            );
        }
    } catch (\Throwable $e) {
        Log::channel('expenses')->error('Notification failed', [
            'expense_id' => $event->expense->id,
            'error' => $e->getMessage()
        ]);
    }
}

    public function failed(ExpenseCreated $event, \Throwable $exception): void
    {
        Log::channel('expenses')->error('Failed to process expense creation', [
            'expense_id' => $event->expense->id,
            'error' => $exception->getMessage()
        ]);
    }
}