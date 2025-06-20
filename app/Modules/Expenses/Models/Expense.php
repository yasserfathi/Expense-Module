<?php

namespace App\Modules\Expenses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasUuids,SoftDeletes;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'title',
        'amount',
        'category',
        'expense_date',
        'notes'
    ];
    
    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'deleted_at' => 'datetime'
    ];

    public function uniqueIds()
    {
        return ['id'];
    }
}