<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ParagraphController;
use App\Models\Employer;
use App\Models\Resume;
use App\Models\Role;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {




    Route::get('/dashboard', function () {
        $user = Auth::user();
        $employers = Employer::where('user_id', $user->id)->with('roles.paragraphs')->get();
        return Inertia::render('Dashboard', ['employers' => $employers]);
    })->name('dashboard');



    Route::post('/paragraph/create', [ParagraphController::class, 'store']);
    Route::post('/paragraph/{paragraph}/update', [ParagraphController::class, 'update']);
    Route::post('/paragraph/{paragraph}/delete', [ParagraphController::class, 'destroy']);


    Route::post('/role/create', [RoleController::class, 'create']);
    Route::post('/role/{role}/delete', [RoleController::class, 'destroy']);
    Route::post('/role/{role}/update', [RoleController::class, 'update']);

    Route::post('/employer/create', [EmployerController::class, 'create']);
    Route::post('/employer/{employer}/update', [EmployerController::class, 'update']);
    Route::post('/employer/{employer}/delete', [EmployerController::class, 'delete']);


    // tinkering
    Route::get('/tinkering', function () {
        $user = Auth::user();
        $employers = Employer::where('user_id', $user->id)->with('roles')->get();


        return $employers;

        // $resume->employers()->attach($employer->id);
        // $resume->employers;

        // $resume = $user->resumes()->first();
        // $employer = new Employer([
        //     'name' => 'First Employer',
        //     'description' => 'description'
        // ]);
        // $employer->user_id = $user->id;
        // $resume->employers()->attach($employer->id);
        // $employer->save();


        // dd($user->id);
        // $resume = new Resume([
        //     'title' => 'Third Resume',
        // ]);

        // $user->resumes()->save($resume);

        // $res = $user->resumes()->get();




    });
});
