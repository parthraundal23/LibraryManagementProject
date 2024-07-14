<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController1 extends Controller
{
    public function dashboard()
    {
        $books = Book::all();
        return view('user.dashboard', compact('books'));
    }

    public function borrow(Book $book)
    {
        // Add logic to handle borrowing the book
        // This could include checking if the book is available, updating the database, etc.
        // For simplicity, we'll assume the book can be borrowed directly.

        $book->borrow(); // Assume there is a borrow method on the Book model
        return redirect()->route('user.dashboard')->with('success', 'Book borrowed successfully!');
    }
}
