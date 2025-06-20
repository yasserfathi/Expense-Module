<?php

namespace App\Modules\Expenses\Repositories;

use App\Modules\Expenses\Models\Expense;

class ExpenseRepository
{
    protected $expenseModel;

    public function __construct(Expense $expenseModel)
    {
        $this->expenseModel = $expenseModel;
    }
    public function getAll(array $filters = [])
    {
        $query = Expense::query();
        
        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        
        return $query->get();
    }
    public function create(array $expenseData)
    {
        return $this->expenseModel->create($expenseData);
    }
    public function update(Expense $expense, array $attributes): Expense
    {
        $expense->update($attributes);
        return $expense->fresh();
    }
    public function delete(Expense $expense): bool
    {
        return $expense->delete();
    }
    public function findOrFail(string $id): Expense
    {
        return $this->expenseModel->findOrFail($id);
    }


}