<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <title>LaraBB Admin Panel</title>
    <body>
        <div id="app">
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
        <script src="{{ mix('/js/bootstrap.js') }}"></script>
    </body>
</html>
