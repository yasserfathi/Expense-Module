<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpenseStoreTest extends TestCase
{
    use RefreshDatabase;

    protected array $validData = [
        'title' => 'Office Supplies',
        'amount' => 125.50,
        'category' => 'cat1',
        'expense_date' => '2023-08-15',
        'notes' => 'Office Supplies'
    ];

    #[Test]
    public function it_creates_an_expense_with_valid_data()
    {
        $user = User::factory()->create(); // Create a test user
        
        $response = $this->actingAs($user) // Authenticate as the user
            ->postJson('/api/expenses', $this->validData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Expense created successfully'
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'amount',
                    'category',
                    'date',
                    'notes',
                    'links' => [
                        'self',
                        'edit'
                    ]
                ]
            ]);

        $this->assertDatabaseHas('expenses', [
            'title' => 'Office Supplies',
            'amount' => 125.50
        ]);
    }
}