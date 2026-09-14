<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ config('app.name', 'Laravel') }}
    </title>

    <link
        rel="dns-prefetch"
        href="//fonts.bunny.net"
    >

    <link
        href="https://fonts.bunny.net/css?family=Nunito"
        rel="stylesheet"
    >

    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js'
    ])

</head>


<body>

<div id="app">

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

        <div class="container">

            <a
                class="navbar-brand fw-bold"
                href="{{ url('/') }}"
            >
                {{ config('app.name', 'Laravel') }}
            </a>


            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="collapse navbar-collapse"
                id="navbarSupportedContent"
            >

                {{-- ================================================= --}}
                {{-- LEFT NAVIGATION --}}
                {{-- ================================================= --}}

                <ul class="navbar-nav me-auto">

                    @auth

                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}"
                                href="{{ route('home') }}"
                            >
                                Dashboard
                            </a>

                        </li>


                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('profile.*') ? 'active fw-bold' : '' }}"
                                href="{{ route('profile.edit') }}"
                            >
                                Profile
                            </a>

                        </li>


                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('password.*') ? 'active fw-bold' : '' }}"
                                href="{{ route('password.edit') }}"
                            >
                                Change Password
                            </a>

                        </li>


                        <li class="nav-item">

                            <a
                                class="nav-link {{ request()->routeIs('login.activities') ? 'active fw-bold' : '' }}"
                                href="{{ route('login.activities') }}"
                            >
                                Login Activity
                            </a>

                        </li>

                    @endauth

                </ul>


                {{-- ================================================= --}}
                {{-- GLOBAL SEARCH --}}
                {{-- ================================================= --}}

                @auth

                    <div class="position-relative me-3">

                        <input
                            type="text"
                            id="globalSearch"
                            class="form-control"
                            placeholder="🔎 Search..."
                            style="width: 220px;"
                            autocomplete="off"
                        >


                        <div
                            id="searchResults"
                            class="position-absolute bg-white border rounded shadow-sm w-100"
                            style="
                                display:none;
                                z-index:1050;
                            "
                        >

                            <a
                                href="{{ route('home') }}"
                                class="dropdown-item"
                                data-search="dashboard home"
                            >
                                📊 Dashboard
                            </a>


                            <a
                                href="{{ route('profile.edit') }}"
                                class="dropdown-item"
                                data-search="profile account user"
                            >
                                👤 Profile
                            </a>


                            <a
                                href="{{ route('password.edit') }}"
                                class="dropdown-item"
                                data-search="password security"
                            >
                                🔐 Change Password
                            </a>


                            <a
                                href="{{ route('login.activities') }}"
                                class="dropdown-item"
                                data-search="login activity history security"
                            >
                                🕐 Login Activity
                            </a>

                        </div>

                    </div>

                @endauth


                {{-- ================================================= --}}
                {{-- RIGHT NAVIGATION --}}
                {{-- ================================================= --}}

                <ul class="navbar-nav ms-auto">

                    @guest

                        <li class="nav-item">

                            <a
                                class="nav-link"
                                href="{{ route('login') }}"
                            >
                                Login
                            </a>

                        </li>


                        <li class="nav-item">

                            <a
                                class="nav-link"
                                href="{{ route('register') }}"
                            >
                                Register
                            </a>

                        </li>

                    @else

                        <li class="nav-item dropdown">

                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                            >
                                {{ Auth::user()->name }}
                            </a>


                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('profile.edit') }}"
                                    >
                                        👤 My Profile
                                    </a>

                                </li>


                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('password.edit') }}"
                                    >
                                        🔐 Change Password
                                    </a>

                                </li>


                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('login.activities') }}"
                                    >
                                        🕐 Login Activity
                                    </a>

                                </li>


                                <li>
                                    <hr class="dropdown-divider">
                                </li>


                                <li>

                                    <form
                                        method="POST"
                                        action="{{ route('logout') }}"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="dropdown-item"
                                        >
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


{{-- ============================================================= --}}
{{-- GLOBAL SEARCH JAVASCRIPT --}}
{{-- ============================================================= --}}

@auth

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('globalSearch');

    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) {
        return;
    }

    const items = searchResults.querySelectorAll('[data-search]');

    searchInput.addEventListener('input', function () {

        const keyword = this.value
            .toLowerCase()
            .trim();

        if (!keyword) {

            searchResults.style.display = 'none';

            items.forEach(function (item) {
                item.style.display = '';
            });

            return;
        }

        let found = false;

        items.forEach(function (item) {

            const text = item
                .dataset.search
                .toLowerCase();

            if (text.includes(keyword)) {

                item.style.display = 'block';

                found = true;

            } else {

                item.style.display = 'none';

            }

        });

        searchResults.style.display =
            found ? 'block' : 'none';

    });


    document.addEventListener('click', function (event) {

        if (
            !searchInput.contains(event.target) &&
            !searchResults.contains(event.target)
        ) {

            searchResults.style.display = 'none';

        }

    });

});

</script>

@endauth

</body>

</html>