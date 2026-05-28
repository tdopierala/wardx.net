<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - wardx.net Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --font-mono: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #0d1117;
            --accent: #58a6ff;
            --surface: #161b22;
            --border-color: #30363d;
        }

        .admin-sidebar {
            background: var(--surface);
            border-right: 1px solid var(--border-color);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 1rem;
        }

        .admin-sidebar .brand {
            font-family: var(--font-mono);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent);
            padding: 0.5rem 1.5rem 1.5rem;
            display: block;
            text-decoration: none;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .admin-sidebar .brand small {
            display: block;
            font-size: 0.7rem;
            color: var(--bs-secondary-color);
            font-weight: 400;
        }

        .admin-sidebar .nav-link {
            font-family: var(--font-mono);
            font-size: 0.85rem;
            color: var(--bs-body-color);
            padding: 0.6rem 1.5rem;
            border-left: 3px solid transparent;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: rgba(88, 166, 255, 0.1);
            border-left-color: var(--accent);
            color: var(--accent);
        }

        .admin-sidebar .nav-link i {
            width: 1.5rem;
        }

        .admin-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .admin-header {
            margin-left: 250px;
            background: var(--surface);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
        }

        .stat-card .stat-value {
            font-family: var(--font-mono);
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
        }

        .stat-card .stat-label {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--bs-secondary-color);
        }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            wardx.net
            <small>admin panel</small>
        </a>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}">
                <i class="bi bi-file-text"></i> Articles
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-folder"></i> Categories
            </a>
            <a class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">
                <i class="bi bi-tags"></i> Tags
            </a>
        </nav>
        <div class="mt-auto p-3" style="position: absolute; bottom: 0; width: 100%; border-top: 1px solid var(--border-color);">
            <a href="{{ route('home') }}" class="nav-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> View Site
            </a>
        </div>
    </aside>

    <header class="admin-header">
        <span class="me-3 text-muted" style="font-size: 0.85rem;">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </header>

    <div class="admin-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
