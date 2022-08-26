<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @vite('resources/js/app.js')
    <script>
        window.Laravel = {!! json_encode(
            [
                'csrfToken' => csrf_token(),
            ],
            JSON_UNESCAPED_UNICODE,
        ) !!};
    </script>
</head>

<body>
    <div class="container" id="app">
        @yield('content')
    </div>


</body>

</html>
