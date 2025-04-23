<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('new_app', 'Wedding Planner') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    @yield('styles')
</head>
<body class="bg-gray-100">
    <div id="app">
        <nav class="bg-white shadow-md py-4">
            <div class="container mx-auto flex justify-between items-center">
                <a class="text-2xl font-semibold" href="{{ url('/') }}">
                    {{ config('new_app', 'Wedding Planner') }}
                </a>
                <button class="lg:hidden text-xl" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="text-gray-600">☰</span>
                </button>

                <div class="lg:flex hidden space-x-6" id="navbarContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="flex space-x-6">
                        @auth
                            <li>
                                <a href="{{ route('weddings.index') }}" class="text-lg text-gray-700 hover:text-blue-600">My Weddings</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="flex space-x-6 ml-auto">
                        @guest
                            @if (Route::has('login'))
                                <li>
                                    <a href="{{ route('login') }}" class="text-lg text-gray-700 hover:text-blue-600">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}" class="text-lg text-gray-700 hover:text-blue-600">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="relative">
                                <a href="#" class="text-lg text-gray-700 hover:text-blue-600">{{ Auth::user()->name }}</a>
                                <ul class="absolute bg-white border shadow-md mt-2 right-0 hidden group-hover:block">
                                    <li>
                                        <a href="{{ route('logout') }}" class="block text-gray-700 hover:bg-gray-200 p-2"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-8">
            <div class="container mx-auto px-4">
                @if(session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Wedding Planner. All rights reserved.</p>
            </div>
        </footer> -->
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    @yield('scripts')
</body>
</html>
