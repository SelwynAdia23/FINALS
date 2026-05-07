<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup { font-size: 0.95rem !important; }
        .btn-action { display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; border: 1px solid transparent; font-size: 0.75rem; font-weight: 500; border-radius: 0.375rem; color: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.15s; cursor: pointer; }
        .btn-action:focus { outline: none; ring: 2px; ring-offset: 2px; }
        .btn-view { background-color: #2563eb; } .btn-view:hover { background-color: #1d4ed8; }
        .btn-edit { background-color: #d97706; } .btn-edit:hover { background-color: #b45309; }
        .btn-delete { background-color: #dc2626; } .btn-delete:hover { background-color: #b91c1c; }
        .btn-add { display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; border: 1px solid transparent; font-size: 0.875rem; font-weight: 500; border-radius: 0.5rem; color: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.15s; cursor: pointer; }
        .btn-add:hover { background-color: #1d4ed8; }
        .colored-toast.swal2-icon-success { background-color: #a5dc86 !important; }
        .colored-toast.swal2-icon-error { background-color: #f27474 !important; }
    </style>
</head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: { popup: 'colored-toast' }
                });
            @endif
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });
            @endif
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: '<ul class="text-sm text-left">{{ implode('', $errors->all('<li>:message</li>')) }}</ul>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626',
                });
            @endif
            function confirmDelete(message) {
                return Swal.fire({
                    title: 'Are you sure?',
                    text: message || 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then((result) => result.isConfirmed);
            }
        </script>
    </body>
</html>
