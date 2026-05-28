<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'wardx.net - Tech blog about coding, AI, and new technologies')">
    <meta name="author" content="wardx.net">
    @yield('meta')
    <title>@yield('title', 'wardx.net') - Tech Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css" rel="stylesheet">
    <link rel="alternate" type="application/rss+xml" title="wardx.net RSS Feed" href="{{ route('feed') }}">
    <style>
        :root {
            --font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', 'Consolas', monospace;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #0d1117;
            --bs-body-color: #c9d1d9;
            --accent: #58a6ff;
            --accent-dim: #1f6feb;
            --surface: #161b22;
            --border-color: #30363d;
        }

        [data-bs-theme="light"] {
            --accent: #0969da;
            --accent-dim: #0550ae;
            --surface: #f6f8fa;
            --border-color: #d0d7de;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
            line-height: 1.6;
        }

        .navbar-brand {
            font-family: var(--font-mono);
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--accent) !important;
        }

        .navbar-brand span {
            color: var(--bs-body-color);
            opacity: 0.5;
        }

        .nav-link {
            font-family: var(--font-mono);
            font-size: 0.85rem;
            text-transform: lowercase;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            transition: border-color 0.2s, transform 0.2s;
        }

        .card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .card-title a {
            color: var(--bs-body-color);
            text-decoration: none;
        }

        .card-title a:hover {
            color: var(--accent);
        }

        .badge-tag {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            padding: 0.25em 0.6em;
            background: var(--accent-dim);
            color: #fff;
            border-radius: 3px;
            text-decoration: none;
        }

        .badge-tag:hover {
            background: var(--accent);
            color: #fff;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--surface) 0%, var(--bs-body-bg) 100%);
            border-bottom: 1px solid var(--border-color);
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .article-content h2, .article-content h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-family: var(--font-mono);
        }

        .article-content pre {
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .article-content code {
            font-family: var(--font-mono);
            font-size: 0.9em;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .article-content blockquote {
            border-left: 4px solid var(--accent);
            padding-left: 1rem;
            margin-left: 0;
            color: var(--bs-secondary-color);
        }

        .article-content table {
            width: 100%;
            margin-bottom: 1rem;
        }

        .article-content table th,
        .article-content table td {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
        }

        .reading-time {
            font-family: var(--font-mono);
            font-size: 0.8rem;
            color: var(--bs-secondary-color);
        }

        .theme-toggle {
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--bs-body-color);
            padding: 0.25rem 0.5rem;
        }

        footer {
            border-top: 1px solid var(--border-color);
            font-family: var(--font-mono);
            font-size: 0.8rem;
        }

        .sidebar-section h5 {
            font-family: var(--font-mono);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--accent);
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top" style="background: var(--surface); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">wardx<span>.net</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">~/home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('feed') }}"><i class="bi bi-rss"></i> feed</a>
                    </li>
                    <li class="nav-item ms-2">
                        <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                            <i class="bi bi-moon-stars" id="themeIcon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="py-4 mt-5">
        <div class="container text-center text-muted">
            <p class="mb-1">&copy; {{ date('Y') }} wardx.net // built with Laravel & Bootstrap</p>
            <p class="mb-0">
                <a href="{{ route('feed') }}" class="text-muted text-decoration-none me-3"><i class="bi bi-rss"></i> RSS</a>
                <a href="{{ route('sitemap') }}" class="text-muted text-decoration-none"><i class="bi bi-diagram-3"></i> Sitemap</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('themeIcon');
            icon.className = theme === 'dark' ? 'bi bi-moon-stars' : 'bi bi-sun';
        }

        (function() {
            const saved = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', saved);
            updateThemeIcon(saved);
        })();
    </script>
    @stack('scripts')
</body>
</html>
