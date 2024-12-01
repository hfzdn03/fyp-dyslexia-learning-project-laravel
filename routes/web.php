<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/learnings', [LearningController::class, 'index'])->name('learnings.index');
    Route::post('/learnings', [LearningController::class, 'store'])->name('learnings.store');
    Route::post('/learnings/{id}', [LearningController::class, 'update'])->name('learnings.update');
    Route::delete('/learnings/{id}', [LearningController::class, 'delete'])->name('learnings.delete');
    Route::get('/learnings/do', [LearningController::class, 'doLearning'])->name('learnings.doLearning');
    Route::get('/learnings/do/{id}', [LearningController::class, 'showDoLearning'])->name('learnings.doLearning.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
