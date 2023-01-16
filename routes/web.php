<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\RoleController;
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
        $employers = Employer::where('user_id', $user->id)->with('roles')->get();
        return Inertia::render('Dashboard', ['employers' => $employers]);
    })->name('dashboard');




    Route::post('/update_employer', [EmployerController::class, 'update']);
    Route::post('/update_role', [RoleController::class, 'update']);

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
