<?php

use App\Http\Controllers\CollectorController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Collector;
use App\Models\Feed;
use App\Models\Source;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {

    Route::get('/dashboard', function () {

        $categories = Category::all();

        $counts = (object) [
            'users' => User::users()->count(),
            'admins' => User::all()->count() - User::users()->count(),
            'feeds' => Feed::all()->count(),
            'categories' => $categories->count(),
            'sources' => Source::all()->count(),
            'collectors' => Collector::all()->count(),
        ];

        $category_views = "";
        foreach ($categories as $category) {
            $category_views .= "['" . $category->name . "'," . $category->view_count . "],";
        }

        return view('dashboard', compact('counts', 'category_views'));
    })->name('dashboard');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

Route::get('/fetch-news', [CollectorController::class, 'store'])->name('fetch');

require __DIR__ . '/auth.php';
