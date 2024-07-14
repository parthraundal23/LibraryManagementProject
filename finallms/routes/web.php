<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

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
    return view('welcome');
})->name('LMS');


//admin routes for login and logout
Route::get('/admin/login', [UserController::class, 'showAdminLoginForm'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [UserController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [UserController::class, 'logout'])->name('admin.logout');




Route::get('/login/user', [UserController::class, 'showUserLoginForm'])->name('user.login')->middleware('guest');
Route::post('/login/user', [UserController::class, 'userLogin']);
Route::post('/user/logout', [UserController::class, 'userlogout'])->name('user.logout');
Route::post('/borrow/{book}', [UserController::class, 'borrow'])->name('book.borrow');
Route::post('/return/{book}', [UserController::class, 'return'])->name('book.return');


    
    
     
    Route::middleware('admin')->group(function () {
      

      Route::get('/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
      Route::get('/admin/dashboard/authors', [AuthorController::class, 'adminAuthors'])->name('admin.authors');
      Route::get('/admin/dashboard/books', [BookController::class, 'adminBooks'])->name('admin.books');
      Route::get('/admin/dashboard/genres', [GenreController::class, 'adminGenres'])->name('admin.genres');

      //Author
Route::get('authors', [AuthorController::class, 'authorindex'])->name('authors.index');
Route::get('authors/create', [AuthorController::class, 'authorcreate'])->name('authors.create');
Route::post('authors', [AuthorController::class, 'storenewAuthor'])->name('authors.storenewAuthor');
Route::get('authors/{author}/edit', [AuthorController::class, 'editAuthor'])->name('authors.editAuthor');
Route::put('authors/{author}', [AuthorController::class, 'updateAuthor'])->name('authors.updateAuthor');
Route::delete('authors/{author}', [AuthorController::class, 'destroyAuthor'])->name('authors.destroyAuthor');

//Books
Route::get('books', [BookController::class, 'bookindex'])->name('books.index');
Route::get('books/create', [BookController::class, 'bookcreate'])->name('books.create');
Route::post('books', [BookController::class, 'bookstore'])->name('books.store');
Route::get('books/{book}/edit', [BookController::class, 'bookedit'])->name('books.edit');
Route::put('books/{book}', [BookController::class, 'bookupdate'])->name('books.update');
Route::delete('books/{book}', [BookController::class, 'bookdestroy'])->name('books.destroy');


//Genre
Route::get('genres', [GenreController::class, 'genreindex'])->name('genres.index');
    Route::get('genres/create', [GenreController::class, 'genrecreate'])->name('genres.create');
    Route::post('genres', [GenreController::class, 'genrestore'])->name('genres.store');
    Route::get('genres/{genre}/edit', [GenreController::class, 'genreedit'])->name('genres.edit');
    Route::put('genres/{genre}', [GenreController::class, 'genreupdate'])->name('genres.update');
    Route::delete('genres/{genre}', [GenreController::class, 'genredestroy'])->name('genres.destroy');


    });

    Route::middleware('user')->group(function () {
       
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    });