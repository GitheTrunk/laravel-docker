<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <div class="container text-center">
            <h1>Welcome to Laravel Application</h1>
            <h5>
                This is a simple Laravel application running inside a Docker container.
                Version: 0.1.0
            </h5>
        </div>
    </body>
       
</html>
