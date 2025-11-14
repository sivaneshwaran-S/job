<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* REMOVE Breeze max width restriction */
        .max-w-md, .max-w-lg, .max-w-xl {
            max-width: none !important;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- REMOVE FLEX-CENTER (this was shrinking the width) -->
    <div class="py-10">
        {{ $slot }}
    </div>

</body>
</html>
