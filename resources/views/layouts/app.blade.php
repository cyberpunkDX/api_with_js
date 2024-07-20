<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">
    <title>Registration With API</title>
</head>
<body>
    @yield('content')
</body>
{{-- <script src="{{ asset('js/app.min.js') }}"></script> --}}
</html>
