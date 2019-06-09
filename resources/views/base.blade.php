<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innaway test</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
    <nav style="margin:20px; font-size: 30px;">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="{{url('/')}}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('transactions.index')}}">CURD</a>
            </li>
        </ul>
    </nav>
    @yield('main')
</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>