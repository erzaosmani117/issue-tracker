<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('projects.index') }}">Issue Tracker</a>
            <div>
                <a href="{{ route('projects.index') }}" class="btn btn-outline-light btn-sm me-2">Projects</a>
                <a href="{{ route('tags.index') }}" class="btn btn-outline-light btn-sm">Tags</a>
                <a href="{{ route('issues.index') }}" class="btn btn-outline-light btn-sm">Issues</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
   <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>