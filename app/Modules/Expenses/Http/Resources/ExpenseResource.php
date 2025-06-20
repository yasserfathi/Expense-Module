<?php

namespace App\Modules\Expenses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'amount' => (float) $this->amount,
            'category' => $this->category,
            'date' => $this->expense_date->format('Y-m-d'),
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'links' => [
                'self' => route('expenses.show', $this->id),
                'edit' => route('expenses.update', $this->id),
            ],
        ];
    }
}