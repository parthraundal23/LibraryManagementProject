<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;  

class BookController extends Controller
{
    public function bookindex(Request $request)
    {
        $query = Book::with(['author', 'genres', 'users']);
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $books = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.books-index', compact('books'));
    }


    public function bookcreate()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('admin.books-create', compact('authors', 'genres'));
    }

    public function bookstore(Request $request)
    {
        $request->validate([
            'author_id' => 'required|exists:authors,id',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'publication_year' => 'required|integer|min:1000|max:9999',
            'genres' => 'array|exists:genres,id',
        ]);

        $book = Book::create($request->only(['author_id', 'title', 'summary', 'publication_year']));
        $book->genres()->sync($request->genres);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function bookedit(Book $book)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $bookGenres = $book->genres->pluck('id')->toArray();
        return view('admin.books-edit', compact('book', 'authors', 'genres', 'bookGenres'));
    }

    public function bookupdate(Request $request, Book $book)
    {
        $request->validate([
            'author_id' => 'required|exists:authors,id',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'publication_year' => 'required|integer|min:1000|max:9999',
            'genres' => 'array|exists:genres,id',
        ]);

        $book->update($request->only(['author_id', 'title', 'summary', 'publication_year']));
        $book->genres()->sync($request->genres);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function bookdestroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
