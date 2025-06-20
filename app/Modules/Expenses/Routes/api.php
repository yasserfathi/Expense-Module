<?PHP

use Illuminate\Support\Facades\Route;
use App\Modules\Expenses\Controllers\ExpenseController;

Route::prefix('expenses')->group(function () {
    Route::get('/', [ExpenseController::class, 'index'])->name('expenses.name');
    Route::post('/', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/{expense}', [ExpenseController::class, 'show'])->name('expenses.show');
    Route::put('/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.delete');
});