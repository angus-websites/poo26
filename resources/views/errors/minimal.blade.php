<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @section('title', "Error")
    </head>
    <body class="antialiased">
        <div class="relative flex justify-center min-h-screen bg-green-50 dark:bg-zinc-800 items-center sm:pt-0"
             role="main">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                    <h1 class="px-4 text-lg dark:text-gray-300 text-gray-700 border-r border-gray-400 tracking-wider">
                        @yield('code')
                    </h1>

                    <div class="ml-4 text-lg dark:text-gray-300 text-gray-700 uppercase tracking-wider">
                        @yield('message')
                    </div>
                </div>
            </div>

        </div>


    </body>
</html>
