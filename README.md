# PHP_Laravel12_Bootsrap_Auth_Scaffolding

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" />
  <img src="https://img.shields.io/badge/Laravel_UI-Auth-0D6EFD?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/Blade-Templates-F7523F?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/Vite-5.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" />
  <img src="https://img.shields.io/badge/Node.js-18%20%7C%2020%20LTS-339933?style=for-the-badge&logo=node.js&logoColor=white" />
</p>


---

##  Overview

This repository is intended for developers who want:

* A **classic Blade-based Laravel app**
* **Bootstrap 5 UI** instead of Tailwind
* Simple, reliable **authentication (Auth)**
* A clean **Vite setup** without React / Inertia complexity

The setup is ideal for:

* Admin panels
* CRUD-based applications
* E‑commerce backends
* Traditional Laravel projects

---

##  Features

* Laravel **12.x**
* Bootstrap **5.x** UI
* Blade templating
* Laravel UI authentication
* Login / Register / Logout
* Protected Dashboard
* CSRF‑safe, POST‑based logout
* Vite (JS + SCSS only)
* Axios preconfigured
* No React / No Inertia

---
## 📂 Folder Structure

```
example-app/
├── app/
│   └── Http/Controllers/
│       ├── Auth/
│       └── HomeController.php
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── sass/
│   │   └── app.scss
│   └── views/
│       ├── auth/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       └── welcome.blade.php
├── routes/
│   └── web.php
├── vite.config.js
└── README.md
```

---
##  Requirements

Make sure your system has:

* PHP **8.2+**
* Composer
* Node.js **18 or 20 (LTS)**
* npm
* MySQL (or any supported database)

Check versions:

```bash
php -v
composer -V
node -v
npm -v
```

---

##  Installation

### Step 1: Create Laravel Project

```bash
composer create-project laravel/laravel example-app
```

---

### Step 2: Install Laravel UI

```bash
composer require laravel/ui
```

---

### Step 3: Generate Bootstrap Auth Scaffolding

```bash
php artisan ui bootstrap --auth
```

This command generates:

* Auth controllers
* Auth routes
* Blade auth views
* Bootstrap-ready layout

---

### Step 4: Install Frontend Dependencies

```bash
npm install

npm install axios
```

---

### Step 5: Configure Vite

Ensure **only this file exists**:

```
vite.config.js
```

❌ Remove if present:

* `vite.config.ts`
* `resources/js/app.tsx`

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

---

### Step 6: JavaScript & SCSS Setup

#### `resources/js/bootstrap.js`

```js
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
```

#### `resources/js/app.js`

```js
import './bootstrap';
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;
```

#### `resources/sass/app.scss`

```scss
@import 'bootstrap/scss/bootstrap';
```

---

### Step 7: Routes Configuration

#### `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
```

---

### Step 8: Layout

#### `resources/views/layouts/app.blade.php`

```blade
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Left Side -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side -->
                <ul class="navbar-nav ms-auto">

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">

                                <!--  GUARANTEED LOGOUT (NO JS ISSUE) -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Logout
                                    </button>
                                </form>

                            </div>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 container">
        @yield('content')
    </main>

</div>
</body>
</html>

```

---

### Step 9: Dashboard Controller

#### `app/Http/Controllers/HomeController.php`

```php
<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
}
```

---

### Step 10: Run Migrations

```bash
php artisan migrate
```

---

### Step 11: Run the Application

Open **two terminals**:

Terminal 1 (Vite):

```bash
npm run dev
```

Terminal 2 (Laravel):

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000
```

---


##  Final Result

* Home Page:-

 <img width="1567" height="491" alt="Screenshot 2026-01-06 131342" src="https://github.com/user-attachments/assets/6c3b4e0e-c1ca-4f6c-9efe-1afd8e368ed9" />

* Register Page:-

  <img width="1566" height="500" alt="Screenshot 2026-01-06 125448" src="https://github.com/user-attachments/assets/cfaeb5d5-6d32-4176-8432-07c9fc8af4c1" />

* Login Page:-

  <img width="1555" height="459" alt="Screenshot 2026-01-06 125500" src="https://github.com/user-attachments/assets/8a7dca20-70cf-459a-ab5c-4e284684c2fe" />

* Dashboard Page:-

  <img width="1526" height="315" alt="Screenshot 2026-01-06 125528" src="https://github.com/user-attachments/assets/fd301edc-97f4-41fa-a96f-46d0aabd2eb0" />



---

## 📌 Notes

* Do not mix Inertia / React with this setup
* Keep `npm run dev` running during development

---

