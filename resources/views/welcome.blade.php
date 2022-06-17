<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <title>Driving License Management System</title>
</head>
<body>
    <div id="app">
            @if(Auth::check())
                <app :user="{{Auth::user()}}"></app>
            @else
                <app :user="false"></app>
            @endif
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>