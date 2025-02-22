    <?php


    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\EmployeeController;
    use App\Http\Controllers\StudentController;

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index']);

    Route::get('/students/search', [StudentController::class, 'index']);
    Route::get('/employees/search', [EmployeeController::class, 'index']);

