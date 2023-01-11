<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- HTML Title --}}
    <title>{{ $title ?? config('app.name') }} | SIKPS STMIK Bandung</title>

    <link rel="shortcut icon" href="{{ Vite::asset('resources/images/favicon.ico') }}">

    <!-- Main styles for this application-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" media="all">
    @stack('css')
</head>

<body>
    {{ $slot }}
</body>

</html>
