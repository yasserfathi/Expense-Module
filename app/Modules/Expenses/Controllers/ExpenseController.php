<?php

namespace App\Modules\Expenses\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Expenses\Http\Resources\ExpenseCollection;
use App\Modules\Expenses\Http\Resources\ExpenseResource;
use App\Modules\Expenses\Services\ExpenseService;
use App\Modules\Expenses\Requests\ExpenseRequest;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response as ApiResponse;
use Knuckles\Scribe\Attributes\QueryParam;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

#[Group('Expenses', 'API for managing expenses')]
class ExpenseController extends Controller
{
    public function __construct(private ExpenseService $expenseService)
    {
    }
    
    #[Endpoint('List all expenses')]
    #[QueryParam('category', 'string', 'Filter by category', required: false, example: 'office')]
    #[ApiResponse(
        status: 200,
        description: 'Success',
        content: ExpenseCollection::class
    )]
    public function index()
    {
        $expenses = $this->expenseService->list(
            request()->only(['category'])
        );

        return (new ExpenseCollection($expenses))
            ->response()
            ->setStatusCode(HttpResponse::HTTP_OK);
    }

    #[Endpoint('Get a single expense')]
    #[ApiResponse(
        status: 200,
        description: 'Success',
        content: ExpenseResource::class
    )]
    #[ApiResponse(
        status: 404,
        description: 'Expense not found',
        content: [
            'success' => false,
            'message' => 'Expense not found'
        ]
    )]
    public function show(string $expense)
    {
        $data = $this->expenseService->find($expense);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found'
            ], HttpResponse::HTTP_NOT_FOUND);
        }

        return (new ExpenseResource($data))
            ->additional([
                'success' => true,
                'message' => 'Expense retrieved successfully'
            ]);
    }
    
    #[Endpoint('Create a new expense')]
    #[ApiResponse(
        status: 201,
        description: 'Expense created',
        content: ExpenseResource::class
    )]
    public function store(ExpenseRequest $request)
    {
        $data = $this->expenseService->create($request->validated());

        return (new ExpenseResource($data))
            ->additional([
                'success' => true,
                'message' => 'Expense created successfully'
            ])
            ->response()
            ->setStatusCode(HttpResponse::HTTP_CREATED);
    }
    
    #[Endpoint('Update an expense')]
    #[ApiResponse(
        status: 200,
        description: 'Expense updated',
        content: ExpenseResource::class
    )]
    public function update(ExpenseRequest $request, string $id)
    {
        $expense = $this->expenseService->update($id, $request->validated());
        
        return (new ExpenseResource($expense))
            ->additional([
                'success' => true,
                'message' => 'Expense updated successfully'
            ]);
    }

    #[Endpoint('Delete an expense')]
    #[ApiResponse(status: 204, description: 'Expense deleted')]
    public function destroy(string $id)
    {
        $this->expenseService->delete($id);
        return response()->noContent();
    }
}