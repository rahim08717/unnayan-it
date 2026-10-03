<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Unnayan Prochesta IT') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Custom Scrollbar & Alpine Cloak Styles -->
        <style>
            [x-cloak] { display: none !important; }
            
            /* Sidebar Custom Scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: rgba(15, 23, 42, 0.6);
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #334155;
                border-radius: 9999px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #475569;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-800 min-h-screen selection:bg-indigo-500 selection:text-white">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col lg:flex-row">
            
            <!-- Left Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Area (lg:pl-72 set for Sidebar Width w-72) -->
            <div class="flex-1 flex flex-col min-w-0 lg:pl-72 transition-all duration-300">
                
                <!-- Page Heading Header -->
                @isset($header)
                    <header class="bg-white/90 backdrop-blur-md shadow-sm border-b border-slate-200/80 sticky top-0 z-30">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Main Page Content -->
                <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>