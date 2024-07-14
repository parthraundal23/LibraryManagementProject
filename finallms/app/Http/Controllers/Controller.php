<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use App\Models\Book;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $genres = Genre::with('book')->get();
        return view('genres.index', compact('genres'));
    }

    public function create()
    {
        $books = Book::all();
        return view('genres.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'name' => 'required|string|max:255',
        ]);

        Genre::create($request->all());

        return redirect()->route('genres.index')->with('success', 'Genre created successfully.');
    }

    public function edit(Genre $genre)
    {
        $books = Book::all();
        return view('genres.edit', compact('genre', 'books'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'name' => 'required|string|max:255',
        ]);

        $genre->update($request->all());

        return redirect()->route('genres.index')->with('success', 'Genre updated successfully.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('genres.index')->with('success', 'Genre deleted successfully.');
    }
}
