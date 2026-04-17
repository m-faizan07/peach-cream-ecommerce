<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('frontend') }}/">
    <title>@yield('title', 'Peach Cream')</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    @include('frontend.components.header')

    @yield('content')

    @include('frontend.components.footer')

    <script src="js/index.js"></script>
    @stack('scripts')
</body>
</html>
