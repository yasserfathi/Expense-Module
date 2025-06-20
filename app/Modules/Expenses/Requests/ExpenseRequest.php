<?php

namespace App\Modules\Expenses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Expenses\Enums\Category;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => $validator->errors(),
            'status' => 409
        ];

        throw new HttpResponseException(response()->json($response));
    }

    public function rules()
    {
        return [
            'title' => [
                'required','string','max:255',Rule::notIn(['untitled', 'undefined']) 
            ],
            'amount' => [
                'required','numeric','min:0.01'
            ],
            'category' => [
                'required','string',
                 new Enum(Category::class)
            ],
            'expense_date' => [
                'required','date','before_or_equal:today'
            ],
            'notes' => [
                'nullable','string','max:1000'
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'An expense title is required',
            'title.not_in' => 'Please provide a meaningful title',
            'amount.min' => 'Expense amount must be at least :min',
            'category.*' => 'Please select a valid category',
            'expense_date.before_or_equal' => 'Expense date cannot be in the future'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'expense title',
            'amount' => 'expense amount',
            'expense_date' => 'date of expense'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => trim($this->title),
            'amount' => (float) $this->amount,
            'notes' => $this->notes ? trim($this->notes) : null
        ]);
    }
}