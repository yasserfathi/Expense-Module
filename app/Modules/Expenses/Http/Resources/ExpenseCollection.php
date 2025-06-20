<?php

namespace App\Modules\Expenses\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => $request->fullUrl(),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'message' => 'Expenses did successfully',
        ];
    }
}