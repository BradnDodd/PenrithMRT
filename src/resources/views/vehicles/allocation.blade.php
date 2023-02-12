<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PenrithMRT Vehicle Allocation</title>

        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-white-100 dark:bg-white-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-white-700 dark:text-white-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-white-700 dark:text-white-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-white-700 dark:text-white-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="relative flex items-top justify-center min-h-screen bg-grey-20 dark:bg-grey-20 sm:items-center py-4 sm:pt-0">
                <table class="table">
                    <th>Name</th>
                    <th>Driving</th>
                    <th>CAS Care</th>
                    <th>ETA</th>
                    <th>Sarcall Response</th>
                    <tr>
                        <td>Test User</td>
                    </tr>
                </table>
            </div>
        </div>

    </body>
</html>
