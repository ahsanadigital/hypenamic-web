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
                    <p style="margin: 0; padding: 0;font-family: 'Open Sans', sans-serif">Selamat Muhammad Aldiansyah pemesanan tiket Anda telah berhasil. Anda telah
                        terdaftar di acara <b style="font-family: 'Open Sans', sans-serif">Comedy On Bus</b> pada kelas <b style="font-family: 'Open Sans', sans-serif">Episode 1 - Jakarta</b>. Saat ini
                        status tiket Anda adalah <b style="font-family: 'Open Sans', sans-serif">Approved</b>.</p>
                </td>
            </tr>
        </table>

        <table style="padding: 1rem 1rem 0 1rem;width: 100%">
            <tr>
                <td width="15%">
                    @php
                        $svg = QrCode::format('svg')->size(200)->generate('https://event.hypenamic.id/verify-tiket/lsjdw66HGE');
                        $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg).'" style="width:100%" />';
                    @endphp
                    {!! $html !!}
                </td>
                <td width="85%">
                    <div style="padding: 1rem; margin-left: 1rem; background: #eee; border-radius: .5rem;font-family: 'Open Sans', sans-serif">
                        <p style="padding: 0; margin: 0;color: #666">Kode Booking Anda</p>
                        <h1 style="padding: 0; margin: 0;font-size: 2.25rem;font-family: 'Montserrat', sans-serif">Testing</h1>
                    </div>
                    <p style="margin-left: 1rem;margin-top: 1rem;font-family: 'Open Sans', sans-serif">Silahkan pindai kode QR disamping untuk mendapatkan informasi + tautan kegiatan daring anda.</p>
                </td>
            </tr>
        </table>
    </div>
    <p style="font-size: 1rem;margin-top:1rem; text-align:center;font-family: 'Open Sans', sans-serif">Supported by <a href="https://event.hypenamic.id">Hypenamic Event</a>.</p>

</body>
</html>
