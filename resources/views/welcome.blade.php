<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CampusConnect') }} - ISUFST Concern Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="min-h-screen">
        <nav class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">CampusConnect</span>
                        <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">ISUFST</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="dark-toggle-welcome" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition" title="Toggle dark mode">
                            <svg id="sun-icon-welcome" class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg id="moon-icon-welcome" class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Log in</a>
                            <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    Campus <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Concern</span> Management
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    A centralized platform for ISUFST students to submit, track, and resolve campus concerns. 
                    Replace paper forms and social media posts with a streamlined ticketing system.
                </p>
                @guest
                    <div class="mt-8 flex justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-500/25">Get Started</a>
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-medium rounded-lg border border-blue-200 dark:border-blue-800 hover:bg-blue-50 dark:hover:bg-gray-600 transition">Sign In</a>
                    </div>
                @endguest
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-800/50 transition">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Submit Concerns</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">One centralized form to report any campus issue - from broken facilities to academic concerns.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-800/50 transition">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/40 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Track Status</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Real-time updates on your concerns - see when they're received, in progress, or resolved.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-800/50 transition">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/40 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Auto Routing</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Concerns are automatically directed to the correct department for faster resolution.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-800/50 transition">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/40 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Photo Evidence</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Upload photos of broken facilities or supporting documents with your concern.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">How It Works</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-xl">1</div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Submit</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Fill out the concern form, select the category and campus, attach photos if needed.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-xl">2</div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Route</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Your concern is automatically sent to the right department based on category.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-xl">3</div>
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Resolve</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Track progress in real-time and receive notification when your concern is resolved.</p>
                    </div>
                </div>
            </div>

            <div class="mt-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-center text-white">
                <h2 class="text-2xl font-bold mb-3">Supported Departments</h2>
                <div class="flex flex-wrap justify-center gap-3 mt-4">
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Maintenance</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Registrar</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Guidance</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">IT Department</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Student Affairs</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Academic Affairs</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Library</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Accounting</span>
                    <span class="px-4 py-2 bg-white/20 rounded-full text-sm">Security</span>
                </div>
            </div>
        </div>

        <footer class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-8 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} CampusConnect - Ilolo State University of Fisheries Science and Technology. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('dark-toggle-welcome');
            if (toggle) {
                toggle.addEventListener('click', function() {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('dark-mode', 'false');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('dark-mode', 'true');
                    }
                });
            }
        });
    </script>
</body>
</html>