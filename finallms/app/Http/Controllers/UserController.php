<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book; 

class UserController extends Controller
{
    //admin fuctionalities
    public function showAdminLoginForm()
    {
        return view('admin.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate with credentials
        if (Auth::attempt($credentials)) {
            // Checks if the authenticated user has the 'admin' role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                // If not an admin, logout and redirect back with error
                Auth::logout();
                return back()->withErrors(['email' => 'You are not authorized to access the admin panel']);
            }
        }

        // If authentication fails, redirect back with error
        return back()->withErrors(['email' => 'Invalid credentials']);

    }

    // Admin dashboard
    public function adminDashboard()
    {
    $authorCount = Author::count();
    $bookCount = Book::count();

    return view('admin.dashboard', compact('authorCount', 'bookCount'));
    }

    
    
    // Admin logout
    public function logout(Request $request)
    {
        Auth::logout();
       
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully');
    }

    // public function dashboard()
    // {
    //     $books = Book::all();
    //     return view('user.userdashboard', compact('books'));
    // }

    public function borrow(Book $book)
    {
        $book->borrow(Auth::id());
        return redirect()->route('user.dashboard')->with('success', 'Book borrowed successfully!');
    }


    public function return(Book $book)
    {
        $book->returnBook(Auth::id());

        
        return redirect()->route('user.dashboard')->with('success', 'Book returned successfully!');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $query = Book::query();


        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'LIKE', "%{$search}%")
                  ->orWhereHas('author', function ($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
        }
        $books = $query->paginate(10);
        $borrowedBooksCount = $user->borrowedBooks()->count();
        return view('user.userdashboard', compact('books', 'borrowedBooksCount'));
    }




    //User Login and other functionalities

    public function showUserLoginForm()
    {
        return view('user.user-login');
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // Attempt to authenticate with credentials
        if (Auth::attempt($credentials)) {
            // Checks if the authenticated user has the 'admin' role
            if (Auth::user()->hasRole('user')) {
                return redirect()->intended(route('user.dashboard'));
            } else {
                // If not an admin, logout and redirect back with error
                Auth::logout();
                return back()->withErrors(['email' => 'You are not authorized to access the admin panel']);
            }
        }

        // If authentication fails, redirect back with error
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function userlogout(Request $request)
    {
        Auth::logout();
       
        return redirect()->route('user.login')->with('success', 'You have been logged out successfully');
    }
}



