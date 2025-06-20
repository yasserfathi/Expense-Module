<?php

namespace App\Modules\Expenses\Events;

use App\Modules\Expenses\Models\Expense;
use Illuminate\Foundation\Events\Dispatchable;

class ExpenseCreated
{
    use Dispatchable;
    public Expense $expense;

    public string $logMessage;
    public function __construct(Expense $expense, string $message = null)
    {
        $this->expense = $expense;
        $this->logMessage = $message ?? "New expense created: {$expense->title} ({$expense->amount})";
    }

    protected function generateDefaultLogMessage(): string
    {
        return sprintf(
            'New expense created: %s (%s %s)',
            $this->expense->title,
            $this->expense->currency,
            number_format($this->expense->amount, 2)
        );
    }

    public function broadcastOn(): array
    {
        return ['expenses'];
    }
}