<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to Your Dashboard</h1>
        <p class="lead">Here are all the available books. You can borrow or return any book by clicking the respective button.</p><br>
        <a class="btn btn-danger" href="{{ route('user.logout') }}" onclick="event.preventDefault(); 
                    document.getElementById('logout-form').submit();" style="margin-left: 93%;">Logout</a><br><br>
                    
        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <form action="{{ route('user.dashboard') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search by title or author" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- <div class="mb-3">
            <h3>Books Borrowed: {{ $borrowedBooksCount }}</h3>
        </div> -->

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>
                            @if ($book->author)
                                {{ $book->author->name }}
                            @else
                                No Author Assigned
                            @endif
                        </td>
                        <td>
                            @php
                                $borrowed = $book->users->contains(function ($user) {
                                    return $user->id === Auth::id() && is_null($user->pivot->returned_at);
                                });
                            @endphp
                            @if ($borrowed)
                                <form action="{{ route('book.return', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Return</button>
                                </form>
                            @else
                                <form action="{{ route('book.borrow', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Borrow</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No books found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $books->appends(['search' => request('search')])->links() }} <!-- Pagination links -->
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
