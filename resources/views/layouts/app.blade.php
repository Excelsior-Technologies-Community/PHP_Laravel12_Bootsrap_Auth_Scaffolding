<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">

    {{-- Bootstrap 5 Theme Initialization Script (Prevents Theme Flash) --}}
    <script>
        (function() {
            const getStoredTheme = () => localStorage.getItem('theme');
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme();
                if (storedTheme) {
                    return storedTheme;
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const setTheme = function (theme) {
                if (theme === 'auto') {
                    document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'));
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme);
                }
            };

            setTheme(getPreferredTheme());
        })();
    </script>

    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js'
    ])

    <style>
        .avatar-initials {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            border-radius: 50%;
            text-transform: uppercase;
        }
        [data-bs-theme="dark"] .bg-white {
            background-color: var(--bs-body-bg) !important;
        }
    </style>
</head>

<body>
<div id="app">
    <nav class="navbar navbar-expand-md border-bottom bg-body shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
                <span class="fs-4">🚀</span>
                <span>{{ config('app.name', 'Laravel') }}</span>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- LEFT NAVIGATION --}}
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold text-primary' : '' }}" href="{{ route('home') }}">
                                📊 Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('profile.edit') }}">
                                👤 Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('password.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('password.edit') }}">
                                🔐 Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login.activities') ? 'active fw-bold text-primary' : '' }}" href="{{ route('login.activities') }}">
                                🕐 Login Activity
                            </a>
                        </li>
                    @endauth
                </ul>

                {{-- GLOBAL SEARCH --}}
                @auth
                    <div class="position-relative me-3 my-2 my-md-0">
                        <input
                            type="text"
                            id="globalSearch"
                            class="form-control form-control-sm"
                            placeholder="🔎 Search pages..."
                            style="width: 200px;"
                            autocomplete="off"
                        >

                        <div
                            id="searchResults"
                            class="position-absolute bg-body border rounded shadow-sm w-100 mt-1"
                            style="display:none; z-index:1050;"
                        >
                            <a href="{{ route('home') }}" class="dropdown-item py-2" data-search="dashboard home">
                                📊 Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item py-2" data-search="profile account avatar photo">
                                👤 Profile & Avatar
                            </a>
                            <a href="{{ route('password.edit') }}" class="dropdown-item py-2" data-search="password security">
                                🔐 Change Password
                            </a>
                            <a href="{{ route('login.activities') }}" class="dropdown-item py-2" data-search="login activity history security">
                                🕐 Login Activity
                            </a>
                        </div>
                    </div>
                @endauth

                {{-- RIGHT NAVIGATION --}}
                <ul class="navbar-nav ms-auto align-items-md-center gap-2">
                    {{-- THEME SWITCHER DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <button
                            class="btn btn-link nav-link dropdown-toggle d-flex align-items-center py-2 px-0 px-md-2"
                            id="bd-theme"
                            type="button"
                            aria-expanded="false"
                            data-bs-toggle="dropdown"
                            data-bs-display="static"
                            aria-label="Toggle theme (auto)"
                        >
                            <span class="theme-icon-active me-1">☀️</span>
                            <span class="d-md-none ms-2" id="bd-theme-text">Toggle theme</span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="bd-theme-text">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between" data-bs-theme-value="light" aria-pressed="false">
                                    <span>☀️ Light</span>
                                    <span class="theme-check d-none">✓</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between" data-bs-theme-value="dark" aria-pressed="false">
                                    <span>🌙 Dark</span>
                                    <span class="theme-check d-none">✓</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between" data-bs-theme-value="auto" aria-pressed="true">
                                    <span>💻 Auto (System)</span>
                                    <span class="theme-check d-none">✓</span>
                                </button>
                            </li>
                        </ul>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-primary px-3" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                @if (Auth::user()->avatar_url)
                                    <img
                                        src="{{ Auth::user()->avatar_url }}"
                                        alt="{{ Auth::user()->name }}"
                                        class="rounded-circle border"
                                        width="30"
                                        height="30"
                                        style="object-fit: cover;"
                                    >
                                @else
                                    <span
                                        class="avatar-initials shadow-sm"
                                        style="width: 30px; height: 30px; font-size: 12px; background-color: {{ Auth::user()->avatar_bg_color }};"
                                    >
                                        {{ Auth::user()->initials }}
                                    </span>
                                @endif

                                <span class="fw-semibold">{{ Auth::user()->name }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-bold text-truncate" style="max-width: 180px;">{{ Auth::user()->name }}</div>
                                    <small class="text-muted text-truncate d-block" style="max-width: 180px;">{{ Auth::user()->email }}</small>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                        👤 My Profile & Photo
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('password.edit') }}">
                                        🔐 Change Password
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('login.activities') }}">
                                        🕐 Login Activity
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                            🚪 Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

{{-- THEME SWITCHER JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const getStoredTheme = () => localStorage.getItem('theme');
    const setStoredTheme = theme => localStorage.setItem('theme', theme);

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();
        if (storedTheme) {
            return storedTheme;
        }
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    };

    const setTheme = theme => {
        if (theme === 'auto') {
            document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'));
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme);
        }
    };

    const showActiveTheme = (theme, focus = false) => {
        const themeSwitcher = document.querySelector('#bd-theme');
        if (!themeSwitcher) return;

        const themeSwitcherText = document.querySelector('#bd-theme-text');
        const activeThemeIcon = document.querySelector('.theme-icon-active');
        const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`);

        document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
            element.classList.remove('active');
            element.setAttribute('aria-pressed', 'false');
            const check = element.querySelector('.theme-check');
            if (check) check.classList.add('d-none');
        });

        if (btnToActive) {
            btnToActive.classList.add('active');
            btnToActive.setAttribute('aria-pressed', 'true');
            const check = btnToActive.querySelector('.theme-check');
            if (check) check.classList.remove('d-none');
        }

        const iconMap = {
            light: '☀️',
            dark: '🌙',
            auto: '💻'
        };

        if (activeThemeIcon) {
            activeThemeIcon.textContent = iconMap[theme] || '☀️';
        }

        if (themeSwitcherText) {
            themeSwitcherText.textContent = `Theme: ${theme.charAt(0).toUpperCase() + theme.slice(1)}`;
        }
    };

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedTheme = getStoredTheme();
        if (storedTheme !== 'light' && storedTheme !== 'dark') {
            setTheme(getPreferredTheme());
        }
    });

    const currentTheme = getStoredTheme() || 'auto';
    setTheme(currentTheme);
    showActiveTheme(currentTheme);

    document.querySelectorAll('[data-bs-theme-value]').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const theme = toggle.getAttribute('data-bs-theme-value');
            setStoredTheme(theme);
            setTheme(theme);
            showActiveTheme(theme, true);
        });
    });
});
</script>

{{-- GLOBAL SEARCH JAVASCRIPT --}}
@auth
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('globalSearch');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) return;

    const items = searchResults.querySelectorAll('[data-search]');

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();

        if (!keyword) {
            searchResults.style.display = 'none';
            items.forEach(item => item.style.display = '');
            return;
        }

        let found = false;
        items.forEach(item => {
            const text = item.dataset.search.toLowerCase();
            if (text.includes(keyword)) {
                item.style.display = 'block';
                found = true;
            } else {
                item.style.display = 'none';
            }
        });

        searchResults.style.display = found ? 'block' : 'none';
    });

    document.addEventListener('click', function (event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.style.display = 'none';
        }
    });
});
</script>
@endauth

</body>
</html>
