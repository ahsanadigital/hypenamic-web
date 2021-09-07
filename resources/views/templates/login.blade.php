<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{!! !empty($title) ? $title : config('app.name') !!}</title>
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('/favicon-16x16.png') }}" type="image/png" />
    <link rel="shortcut icon" href="{{ asset('/favicon-32x32.png') }}" type="image/png" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @yield('header')
</head>

<body class="bg-lighter">

    <div class="garuda-login">
        <!-- Left Side -->
        <div class="left-side d-flex flex-column justify-content-between">
            <!-- Logo Header -->
            <a href="{{ route('home') }}" class="logo-top">
                <img loading="lazy" src="{{ asset('assets/images/brands/hypenamic-event-color.png') }}" alt="Hypenamic Studio" height="50px" />
            </a>

            <!-- Form Initialize -->
            @yield('container')

            <footer class="footer">
                <span>Hak Cipta <a href="">Hypenamic Studio&trade;</a></span>
            </footer>

        </div>
        <div class="right-side" style="background-image: url({{ asset('assets/images/header.jpg') }})"></div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
    "use strict";

    const confirmModal = Swal.mixin({
        icon: 'question',
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-success btn-block',
            cancelButton: 'btn btn-light btn-block'
        },
        buttonsStyling: false
    });
    const confirmAltModal = Swal.mixin({
        icon: 'warning',
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-danger btn-block',
            cancelButton: 'btn btn-light btn-block'
        },
        buttonsStyling: false
    });
    const warnAlert = Swal.mixin({
        icon: 'warning',
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-warning btn-block',
        },
        buttonsStyling: false
    });
    const successAlert = Swal.mixin({
        icon: 'success',
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-success btn-block',
        },
        buttonsStyling: false
    });
    const errorAlert = Swal.mixin({
        icon: 'error',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-danger btn-block',
        },
        buttonsStyling: false
    });
    const infoAlert = Swal.mixin({
        icon: 'info',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-info btn-block',
        },
        buttonsStyling: false
    });

    @if (session('error'))
    errorAlert.fire('Kesalahan!', '{{ session("error") }}', 'error')
    @elseif(session('success'))
    successAlert.fire('Berhasil', '{{ session("success") }}', 'success')
    @elseif(session('warning'))
    warnAlert.fire('Peringatan!', '{{ session("warning") }}', 'warning')
    @elseif(session('info'))
    infoAlert.fire('Informasi.', '{{ session("info") }}', 'info')
    @endif
    </script>

    @yield('footer')
</body>
</html>
