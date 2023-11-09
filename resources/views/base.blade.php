<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include_once('partials/_head')
<body>
    @yield('main')
</body>
</html>