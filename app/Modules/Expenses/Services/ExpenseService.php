<?php

namespace App\Modules\Expenses\Services;

use App\Modules\Expenses\Models\Expense;
use App\Modules\Expenses\Repositories\ExpenseRepository;
use App\Modules\Expenses\Events\ExpenseCreated;

class ExpenseService
{
    public function __construct(
        private ExpenseRepository $expenseRepository
    ) {}
    
    public function list(array $filters = [])
    {
        return $this->expenseRepository->getAll($filters);
    }
    
    public function create(array $data): Expense
    {
        $expense = $this->expenseRepository->create($data);
        event(new ExpenseCreated($expense));
        return $expense;
    }
    
    public function update(int $id, array $data): Expense
    {
        $expense = $this->expenseRepository->findOrFail($id);
        $updatedExpense = $this->expenseRepository->update($expense, $data);
        event(new ExpenseUpdated($updatedExpense));
        return $updatedExpense;
    }

    public function delete(string $id): void
    {
        $expense = $this->expenseRepository->findOrFail($id);
        $this->expenseRepository->delete($expense);
       // event(new ExpenseDeleted($expense->id));
    }

    public function find(string $id): Expense
    {
        return $this->expenseRepository->findOrFail($id);
    }
}