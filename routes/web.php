<?php

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
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // tinkering
    Route::get('/tinkering', function () {
        $user = Auth::user();
        $employer = Employer::find(2);
        $role = new Role([
            'title' => 'Role Title',
            'description' => 'Role description',
            'start' => new dateTime('2020/10/01'),
        ]);
        $role->employer_id = $employer->id;
        $role->user_id = $user->id;
        $role->save();

        $roles = $user->roles()->get();

        return $roles;

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
