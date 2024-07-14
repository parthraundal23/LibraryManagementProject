<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
   // AuthorController.php

    public function authorindex(Request $request)
     {
    $query = Author::query();

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('name', 'LIKE', "%{$search}%");
    }

    $authors = $query->orderBy('id', 'desc')->paginate(10); // Change 'id' to whatever column you want to order by
    return view('admin.author-index', compact('authors'));
    }

    public function authorcreate()
    {
        return view('admin.author-create');
    }

    public function storenewAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        Author::create($request->all());

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    public function editAuthor(Author $author)
    {
        return view('admin.author-edit', compact('author'));
    }

    public function updateAuthor(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $author->update($request->all());

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroyAuthor(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}

