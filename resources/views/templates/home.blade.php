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
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" />

    <style>
        section.footer a {
            color: white;
        }

        @media screen and (max-width: 600px) {
            .widget {
                border-bottom: 1px solid rgba(255,255,255,.15);
                margin-bottom: 1rem;
                padding: 1rem 0;
            }
        }

        .has-arrow a {
            transition: all .2s;
        }
        .has-arrow a::before {
            content: '\f061';
            font-family: 'Font Awesome 5 Free';
            font-weight: 700;
            margin-right: .5rem;
            /* display: none; */
            transition: all .2s;
        }
    </style>

    @yield('header')
</head>
<body>

    {{-- Navbar Main --}}
    <nav class="navbar navbar-expand-md navbar-light border-bottom bg-white">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img loading="lazy" src="{{ asset('assets/images/brands/hypenamic-event-color.png') }}" alt="Hypenamic Studio" height="50px" />
            </a>
            <a class="btn btn-outline-warning d-md-none" href="#" tabindex="-1" aria-disabled="true">
                <i class="fas fa-sign-in-alt fa-fw"></i>
            </a>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item{{ request()->routeIs('home') ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home fa-fw mr-2"></i>Beranda</a>
                    </li>
                    <li class="nav-item{{ request()->routeIs('jelajah*') ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('jelajah') }}"><i class="fas fa-calendar mr-2 fa-fw"></i>Event</a>
                    </li>
                    <div class="nav-item">
                        <a class="nav-link" href="https://blog.hypenamic.id"><i class="fas fa-file fa-fw mr-2"></i>Blog</a>
                    </div>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>Buat Eventmu!</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-header px-3"><a href="" class="btn btn-block btn-outline-warning">Buat Sekarang!</a></div>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('pricing') }}">Harga Layanan</a>
                            <a class="dropdown-item" href="{{ url('/faq') }}">F&Q</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-warning" href="{{ route('user.login') }}">
                            <i class="fas fa-sign-in-alt fa-fw"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Your Content Are Here  --}}
    @yield('container')

    <footer id="main-footer" class="footer">
        <section class="bg-dark py-5 footer text-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{ asset('assets/images/brands/hypenamic-event-white.png') }}" alt="Hypenamic Event" class="w-100 mb-3" />
                        <p>Hypenamic Event adalah bagian dari Hypenamic Studio yang mana bergerak pada bidang Event Organizer untuk berbagai acara.</p>
                    </div>
                    <div class="col-md">

                        <div class="row">
                            <div class="col-md-4">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-map-pin fa-fw mr-2"></i>Jl. Pagesangan Asri 1 AA 51, Kelurahan Pagesangan, Kecamatan Jambangan, Kota Surabaya, Jawa Timur</li>
                                    <li><i class="fas fa-phone fa-fw mr-2"></i>0857-7772-1212</li>
                                    <li><i class="fas fa-envelope fa-fw mr-2"></i>admin@hypenamic.id</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="widget">
                                    <h3 class="h4">Tentang Kami</h3>
                                    <div class="nav nav-pills has-arrow flex-column">
                                        <a href="" class="nav-link nav-item">Tentang Kami</a>
                                        <a href="{{ route('pricing') }}" class="nav-link nav-item">Harga Layanan</a>
                                        <a href="{{ route('tos') }}" class="nav-link nav-item">Syarat dan Ketentuan Layanan</a>
                                        <a href="{{ route('privasi') }}" class="nav-link nav-item">Kebijakan Privasi</a>
                                        <a href="https://blog.hypenamic.id" class="nav-link nav-item">Blog</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="widget">
                                    <h3 class="h4">Tautan Terkait</h3>
                                    <div class="nav nav-pills has-arrow flex-column">
                                        <a href="{{ route('invoice-main') }}" class="nav-link nav-item">Cek Tagihan</a>
                                        <a href="{{ route('invoice-main') }}" class="nav-link nav-item">Bayar Tagihan</a>
                                        <a href="" class="nav-link nav-item">Akun Saya</a>
                                        <a href="" class="nav-link nav-item">Mendaftar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-warning py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-left">
                        <p class="m-0">Hak Cipta {{ date('Y') }}, <a class="text-dark font-weight-bold" href="{{ url('/') }}">{{ config('app.name') }}</a></p>
                    </div>
                    <div class="col-md-6 text-center text-md-right"></div>
                </div>
            </div>
        </section>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
    "use strict";

    const confirmModal = Swal.mixin({
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-success btn-block',
            cancelButton: 'btn btn-light btn-block'
        },
        buttonsStyling: false
    });
    const confirmAltModal = Swal.mixin({
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-danger btn-block',
            cancelButton: 'btn btn-light btn-block'
        },
        buttonsStyling: false
    });
    const warnAlert = Swal.mixin({
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-warning btn-block',
        },
        buttonsStyling: false
    });
    const successAlert = Swal.mixin({
        confirmButtonText: 'Tutup',
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-success btn-block',
        },
        buttonsStyling: false
    });
    const errorAlert = Swal.mixin({
        customClass: {
            actions: 'px-4',
            confirmButton: 'btn btn-danger btn-block',
        },
        buttonsStyling: false
    });
    const infoAlert = Swal.mixin({
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
