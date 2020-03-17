<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('common.sys_name')  }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
    <!-- Styles -->
</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md navbar-light shadow-sm">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ __('common.sys_name')  }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <!-- Authentication Links -->
                    @guest

                    @else
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-warning btn-lg btn-fixed-width">{{__('common.logout')}}</button>
                    </form>
                    @endguest
                </div>
            </nav>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>
        window._translations = {!! cache('translations') !!};
    </script>
</body>
</html>
