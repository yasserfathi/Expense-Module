<?php

namespace App\Modules\Expenses\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpenseCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $expense,
        public string $via
    ) {}

    public function via($notifiable): array
    {
        return [$this->via];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject("New Expense Created: {$this->expense->title}")
            ->line("Amount: {$this->expense->amount}")
            ->line("Category: {$this->expense->category}")
            ->action('View Expense', route('expenses.show', $this->expense->id));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New expense {$this->expense->title} created",
            'amount' => $this->expense->amount,
            'link' => route('expenses.show', $this->expense->id)
        ];
    }
}