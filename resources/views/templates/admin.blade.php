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

    <!-- Addons -->
    <link rel="stylesheet" href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" id="boxicon-2" />
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.css') }}" id="fontawesome-5" />
</head>

<body>

    <div id="app">
        <section class="sidebar sidebar-dark bg-dark">
            <div class="sidebar-header">
                <a href="{{ route('admin.main') }}">
                    <img loading="lazy" src="{{ asset('assets/images/brands/hypenamic-event-color.png') }}" alt="Hypenamic Studio" height="40px" class="d-md-none" />
                    <img loading="lazy" src="{{ asset('assets/images/brands/hypenamic-event-white.png') }}" alt="Hypenamic Studio" height="40px" class="d-md-flex d-none d-sm-none" />
                </a>
                <i class="fas fa-times close-indicator d-md-none"></i>
            </div>

            <div class="sidebar-body">

                <ul id="garudasidenav" class="sidebar-wrapper">

                    <a href="{{ route('admin.event-add') }}" class="btn btn-primary btn-block w-100"><i class="fas fa-plus mr-2"></i>Tambah Event</a>

                    <!-- Dashboard Menu -->
                    <div class="sidebar-heading">Dasbor</div>

                    <li class="sidebar-item">
                        <a href="{{ route('admin.main') }}" class="sidebar-link{{ Route::is('admin.main') ? ' active' : '' }}">
                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                            <div class="content">Dasbor</div>
                        </a>
                    </li>

                    <!-- Data Management -->
                    <div class="sidebar-heading">Manajemen Data</div>

                    <li class="sidebar-item{{ Route::is('admin.event-*') ? ' mm-active' : '' }}">
                        <a href="#" class="sidebar-link drop-trigger" aria-expanded="false">
                            <span class="icon"><i class="bx bx-calendar"></i></span>
                            <span class="content">Event</span>
                        </a>
                        <ul class="submenu">
                            <div class="submenu-wrapper">
                                <li class="submenu-item">
                                    <a href="{{ route('admin.event-main') }}" class="submenu-link{{ Route::is('admin.event-main') ? ' active' : '' }}">Semua Event</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="{{ route('admin.event-category-main') }}" class="submenu-link">Semua Kategori</a>
                                </li>

                                <li class="submenu-item">
                                    <a href="javascript:void(0)" class="submenu-link drop-trigger" aria-expanded="false">Tambah</a>

                                    <ul class="submenu" >
                                        <div class="submenu-wrapper">
                                            <li class="submenu-item">
                                                <a href="{{ route('admin.event-add') }}" class="submenu-link{{ Route::is('admin.event-add') ? ' active' : '' }}">Tambah Event</a>
                                            </li>
                                            <li class="submenu-item">
                                                <a href="{{ route('admin.event-category-main') }}" class="submenu-link">Tambah Kategori</a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <li class="sidebar-item{{ Route::is('admin.pelanggan-*') ? ' mm-active' : '' }}">
                        <a href="#" class="sidebar-link drop-trigger" aria-expanded="false">
                            <span class="icon"><i class="bx bx-user"></i></span>
                            <span class="content">Data Pelanggan</span>
                        </a>
                        <ul class="submenu" data-depth="first">
                            <div class="submenu-wrapper">
                                <li class="submenu-item">
                                    <a href="{{ route('admin.pelanggan-main') }}" class="submenu-link{{ Route::is('admin.pelanggan-main') ? ' active' : '' }}">Semua Pelanggan</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="javascript:void(0)" class="submenu-link">Tambah Pelanggan</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <div class="icon"><i class="bx bx-coin"></i></div>
                            <div class="content">Data Transaksi</div>
                        </a>
                    </li>

                </ul>
            </div>
        </section>
        <div class="overlay"></div>
        <main class="admin-container">

            <div id="content-wrapper">
                <!-- Navbar -->
                <nav class="navbar navbar-expand navbar-light bg-white border-bottom">
                    <button type="button" class="btn d-md-none btn-outline-light toggle-sidebar"><i class="fas fa-list"></i></button>

                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item mx-3 mx-md-0"><span class="nav-link text-white badge badge-success" id="time"></span></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="homeDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-home fa-fw mr-1"></i>
                                    <span class="d-none d-lg-inline d-md-none">Sistem Tiket Online</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-alt" aria-labelledby="homeDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">Lihat Beranda</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)">Tentang Aplikasi</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user mr-1"></i>
                                    <span class="d-none d-md-inline d-sm-none">{{ auth()->user()->fullname }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-alt dropdown-menu-right" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:warningFunction()">Keluar</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                @yield('container')
            </div>

            <footer class="py-4 bg-white border-top mt-3">
                <div class="container-fluid">
                    <span>Hak Cipta {{ now()->format('Y') }}, <a href="{{ route('home') }}">{{ config('app.name') }}</a>.</span>
                </div>
            </footer>

        </main>
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
            cancelButton: 'btn btn-light btn-block mt-3',
        },
        buttonsStyling: false
    });
    const successAlert = Swal.mixin({
        icon: 'success',
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-success btn-block',
            cancelButton: 'btn btn-light btn-block mt-3',
        },
        buttonsStyling: false
    });
    const errorAlert = Swal.mixin({
        icon: 'error',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-danger btn-block',
            cancelButton: 'btn btn-light btn-block mt-3',
        },
        buttonsStyling: false
    });
    const infoAlert = Swal.mixin({
        icon: 'info',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-info btn-block',
            cancelButton: 'btn btn-light btn-block mt-3',
        },
        buttonsStyling: false
    });

    function warningFunction() {
        warnAlert.fire({
            title: 'Kamu yakin mau keluar?',
            text: 'Datamu tadi yang belum tersimpan akan hilang ya? Jika sudah tersimpan silahkan tekan tombol "ya".',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Batal',
            allowEscapeKey: false,
            allowOutsideClick: false,
            customClass: {
                actions: 'px-4',
                confirmButton: 'btn btn-danger btn-block mb-2',
                cancelButton: 'btn btn-light btn-block',
            },
        }).then(result => {
            if(result.isConfirmed) {
                Swal.fire({
                    title: 'Sedang Memproses!',
                    text: 'Sedang mengeluarkan anda dari sesi ini.',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen() {
                        Swal.showLoading()
                    }
                });

                window.location.href = '{{ route("logout") }}';
            } else {
                Swal.close();
            }
        });
    }

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
