{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>Tiket Anda</title>

    <style>
    /** Page Main */
    body {
        margin: 0;
        padding: 0;
        font-size: 16px;
        font-family: Arial, Helvetica, sans-serif;
    }
    @page {
        margin: 0;
        padding: 0;
    }

    /** Bootstrap */
    .m-0 {
    margin: 0 !important;
    }

    .mt-0,
    .my-0 {
    margin-top: 0 !important;
    }

    .mr-0,
    .mx-0 {
    margin-right: 0 !important;
    }

    .mb-0,
    .my-0 {
    margin-bottom: 0 !important;
    }

    .ml-0,
    .mx-0 {
    margin-left: 0 !important;
    }

    .m-1 {
    margin: 0.25rem !important;
    }

    .mt-1,
    .my-1 {
    margin-top: 0.25rem !important;
    }

    .mr-1,
    .mx-1 {
    margin-right: 0.25rem !important;
    }

    .mb-1,
    .my-1 {
    margin-bottom: 0.25rem !important;
    }

    .ml-1,
    .mx-1 {
    margin-left: 0.25rem !important;
    }

    .m-2 {
    margin: 0.5rem !important;
    }

    .mt-2,
    .my-2 {
    margin-top: 0.5rem !important;
    }

    .mr-2,
    .mx-2 {
    margin-right: 0.5rem !important;
    }

    .mb-2,
    .my-2 {
    margin-bottom: 0.5rem !important;
    }

    .ml-2,
    .mx-2 {
    margin-left: 0.5rem !important;
    }

    .m-3 {
    margin: 1rem !important;
    }

    .mt-3,
    .my-3 {
    margin-top: 1rem !important;
    }

    .mr-3,
    .mx-3 {
    margin-right: 1rem !important;
    }

    .mb-3,
    .my-3 {
    margin-bottom: 1rem !important;
    }

    .ml-3,
    .mx-3 {
    margin-left: 1rem !important;
    }

    .m-4 {
    margin: 1.5rem !important;
    }

    .mt-4,
    .my-4 {
    margin-top: 1.5rem !important;
    }

    .mr-4,
    .mx-4 {
    margin-right: 1.5rem !important;
    }

    .mb-4,
    .my-4 {
    margin-bottom: 1.5rem !important;
    }

    .ml-4,
    .mx-4 {
    margin-left: 1.5rem !important;
    }

    .m-5 {
    margin: 3rem !important;
    }

    .mt-5,
    .my-5 {
    margin-top: 3rem !important;
    }

    .mr-5,
    .mx-5 {
    margin-right: 3rem !important;
    }

    .mb-5,
    .my-5 {
    margin-bottom: 3rem !important;
    }

    .ml-5,
    .mx-5 {
    margin-left: 3rem !important;
    }
    .w-100 {
        width: 100%;
    }

    .table {
        width: 100%;
        border-spacing: 0px;
    }

    /** Heading */
    #masthead {
        background: rgb(228, 187, 3);
        padding: 1rem;
    }
    #masthead .table {
        width: 100%;
        border-spacing: 0px;
    }
    #masthead .left {
        width: 25%;
    }
    #masthead .right {
        width: 75%;
    }

    #masthead .table td.left {
        width: 20%;
    }
    #masthead .table td.right {
        width: 80%;
    }

    /** Body */
    #body {
        padding-top: 1.5rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    main#body table {
        width: 100%;
        border-spacing: 0px;
    }
    main#body table td {
        padding: .75rem;
    }
    main#body table tr.stripe td {
        background: #eee;
        border: 1px solid #eee;
    }
    </style>
</head>
<body>

    <header id="masthead">
        <table class="w-100">
            <tbody>
                <tr>
                    <td class="left">
                        <img alt="Hypenamic Studio" height="60px" src="{{ asset('assets/images/brands/hypenamic-event-black.png') }}" />
                    </td>
                    <td class="right">
                        <h3 class="m-0">Pemesanan Tiket Anda</h3>
                        <p class="m-0">Berikut detail reservasi tiket yang telah anda pesan.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </header>

    <main id="body">
        <table outline=0>
            <tbody>
                <tr>
                    <td width="35%">ID Registrasi Tiket</td>
                    <td>{{ $ticks }}</td>
                </tr>
                <tr class="stripe">
                    <td width="35%">Nama Lengkap</td>
                    <td>{{ "{$first_name} {$last_name}" }}</td>
                </tr>
                <tr>
                    <td width="35%">Email</td>
                    <td>{{ $email }}</td>
                </tr>
                <tr class="stripe">
                    <td width="35%">Nomor HP</td>
                    <td>{{ $nomor_hp }}</td>
                </tr>
                <tr>
                    <td width="35%">Event</td>
                    <td><strong>{{ $event->event_name }}</strong> dengan tiket <strong>{{ $tiket->ticket_name }}</strong></td>
                </tr>
            </tbody>
        </table>

        <p>Setelah membeli tiket ini diharapkan untuk menunjukkannya kepada panitia agar anda dapat mengikuti event ini dan dapat segera ditindaklanjuti oleh panitia.</p>
    </main>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Test</title>
    <style>
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: normal;
            src: url(https://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
        }
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: bold;
            src: url(https://cdn.jsdelivr.net/npm/@typopro/web-montserrat@3.7.5/TypoPRO-Montserrat-Bold.ttf) format('truetype');
        }
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: bold;
            src: url(https://cdn.jsdelivr.net/npm/@typopro/web-open-sans@3.7.5/TypoPRO-OpenSans-Bold.ttf) format('truetype');
        }
        body, * {
            margin: 0;
            padding: 0;
            ;
        }
        @page {
            margin: 0;
            padding: 0;
        }
        p {
            font-size: 1.35rem;
            line-height: 0.9rem;
        }
    </style>
</head>
<body>

    <div style="padding: 2rem 1rem;margin: 7rem 1rem 0rem 1rem; border-radius: .5rem; border: 1px solid rgb(230, 230, 230);">
        <table>
            <tr>
                <td>
                    <img src="https://static.hypenamic.id/letterhead.png" width="100%" />
                </td>
            </tr>
        </table>

        <table width="100%" style="padding: 0 1rem;">
            <tr>
                <td>
                    <p style="margin: 0; padding: 0;font-family: 'Open Sans', sans-serif">Selamat {{ $first_name }} {{ $last_name }} pemesanan tiket Anda telah berhasil. Anda telah terdaftar di acara <b style="font-family: 'Open Sans', sans-serif">{{ $event->event_name }}</b> pada kelas <b style="font-family: 'Open Sans', sans-serif">{{ $tiket->ticket_name }}</b>.</p>
                </td>
            </tr>
        </table>

        <table style="padding: 1rem 1rem 0 1rem;width: 100%">
            <tr>
                <td width="15%">
                    @php
                        $svg  = QrCode::format('svg')->size(200)->generate(route('verify-tiket-main', $ticks));
                        $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg).'" style="width:100%" />';
                    @endphp
                    {!! $html !!}
                </td>
                <td width="85%">
                    <div style="padding: 1rem; margin-left: 1rem; background: #eee; border-radius: .5rem;font-family: 'Open Sans', sans-serif">
                        <p style="padding: 0; margin: 0;color: #666">Kode Booking Anda</p>
                        <h1 style="padding: 0; margin: 0;font-size: 2.25rem;font-family: 'Montserrat', sans-serif">{{ $ticks }}</h1>
                    </div>
                    <p style="margin-left: 1rem;margin-top: 1rem;font-family: 'Open Sans', sans-serif">Silahkan pindai kode QR disamping untuk mendapatkan informasi + tautan kegiatan daring anda.</p>
                </td>
            </tr>
        </table>
    </div>
    <p style="font-size: 1rem;margin-top:1rem; text-align:center;font-family: 'Open Sans', sans-serif">Supported by <a href="https://event.hypenamic.id">Hypenamic Event</a>.</p>

</body>
</html>
