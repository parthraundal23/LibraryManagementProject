<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function genreindex()
    {
        $genres = Genre::all();
        return view('admin.genre-index', compact('genres'));
    }

    public function genrecreate()
    {
        $books = Book::all();
        return view('admin.genre-create', compact('books'));
    }

    public function genrestore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'book_id' => 'required|exists:books,id', // Validate that the book_id exists in the books table
    ]);
    $books = Book::all();

    // Create a new Genre instance with all required fields
    $genre = new Genre();
    $genre->name = $request->name;
    $genre->book_id = $request->book_id;
    $genre->save();

    return redirect()->route('genres.index')->with('success', 'Genre created successfully.');
}





    public function genreedit(Genre $genre)
    {
        $books = Book::all();
        return view('admin.genre-edit', compact('genre', 'books'));
    }

    public function genreupdate(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'book_id' => 'required|exists:books,id',
        ]);

        $genre->update($request->all());

        return redirect()->route('genres.index')->with('success', 'Genre updated successfully.');
    }

    public function genredestroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('genres.index')->with('success', 'Genre deleted successfully.');
    }
}
