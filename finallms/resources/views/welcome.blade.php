<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg {
            background-color: #f8f9fa;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .container {
            max-width: 600px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        .btn-lg {
            width: 100%;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="bg">
        <div class="container">
            <h1>Welcome to the Library Management System</h1>
            <p class="lead">Please choose an option to proceed.</p>
            <div class="d-flex flex-column">
                <a href="{{ route('admin.login') }}" class="btn btn-primary btn-lg">Login for Admin</a>
                <a href="{{ route('user.login') }}" class="btn btn-secondary btn-lg">Login for User</a>
              
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

