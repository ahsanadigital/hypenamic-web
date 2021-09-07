<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Email Template</title>
        <style>
            img{border:none;-ms-interpolation-mode:bicubic;max-width:100%}body{background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table{border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%}table td{font-family:sans-serif;font-size:14px;vertical-align:top}.body{background-color:#f6f6f6;width:100%}.container{display:block;margin:0 auto!important;max-width:580px;padding:10px;width:580px}.content{box-sizing:border-box;display:block;margin:0 auto;max-width:580px;padding:10px}.main{background:#fff;border-radius:8px;width:100%;box-shadow:0 4px 24px #eee}.wrapper{box-sizing:border-box;padding:20px}.content-block{padding-bottom:10px;padding-top:10px}.footer{clear:both;margin-top:10px;text-align:center;width:100%}.footer a,.footer p,.footer span,.footer td{color:#999;font-size:12px;text-align:center}h1,h2,h3,h4{color:#000;font-family:sans-serif;font-weight:400;line-height:1.4;margin:0;margin-bottom:30px}h1{font-size:35px;font-weight:300;text-align:center;text-transform:capitalize}ol,p,ul{font-family:sans-serif;font-size:14px;font-weight:400;margin:0;margin-bottom:15px}ol li,p li,ul li{list-style-position:inside;margin-left:5px}a{color:#3498db;text-decoration:underline}.btn{box-sizing:border-box;width:100%}.btn>tbody>tr>td{padding-bottom:15px}.btn table{width:auto}.btn table td{background-color:#fff;border-radius:8px;text-align:center}.btn a{background-color:#fff;border:solid 1px #3498db;border-radius:8px;box-sizing:border-box;color:#3498db;cursor:pointer;display:inline-block;font-size:14px;font-weight:700;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize}.btn-primary table td{background-color:#3498db}.btn-primary a{background-color:#3498db;border-color:#3498db;color:#fff}.last{margin-bottom:0}.first{margin-top:0}.align-center{text-align:center}.align-right{text-align:right}.align-left{text-align:left}.clear{clear:both}.mt0{margin-top:0}.mb0{margin-bottom:0}.preheader{color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0}.powered-by a{text-decoration:none}hr{border:0;border-bottom:1px solid #f6f6f6;Margin:20px 0}@media only screen and (max-width:620px){table[class=body] h1{font-size:28px!important;margin-bottom:10px!important}table[class=body] a,table[class=body] ol,table[class=body] p,table[class=body] span,table[class=body] td,table[class=body] ul{font-size:16px!important}table[class=body] .article,table[class=body] .wrapper{padding:10px!important}table[class=body] .content{padding:0!important}table[class=body] .container{padding:0!important;width:100%!important}table[class=body] .main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table[class=body] .btn table{width:100%!important}table[class=body] .btn a{width:100%!important}table[class=body] .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}}@media all{.ExternalClass{width:100%}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}.btn-primary table td:hover{background-color:#34495e!important}.btn-primary a:hover{background-color:#34495e!important;border-color:#34495e!important}}table.information{border:1px solid #e6e6e6;padding:0!important;border-radius:8px;margin:24px 0}table.information tr td{padding:16px 14px}table.information tr:not(:last-child) td{border-bottom:1px solid #e6e6e6}
        </style>
    </head>
    <body class="">
        <table border="0" cellpadding="0" cellspacing="0" class="body">
            <tr>
                <td>&nbsp;</td>
                <td class="container">
                    <div class="content">
                        <!-- START CENTERED WHITE CONTAINER -->
                        <span class="preheader">Faktur Tagihan Anda</span>
                        <table style="margin-bottom: 16px;">
                            <tr>
                                <td align="center">
                                    <a href="https://event.hypenamic.id">
                                    <img src="https://static.hypenamic.id/brands/hypenamic-event-color.png" alt="Hypenamic Studio" height="50px" />
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <table class="main">
                            <!-- START MAIN CONTENT AREA -->
                            <tr>
                                <td class="wrapper">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <p>Halo {{ "{$first_name} {$last_name}" }},</p>
                                                <p>Terima kasih telah memesan tiket kami, dan berikut kami berikan informasi terkait tagihan anda.</p>
                                                <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                                    <tbody>
                                                        <tr>
                                                            <td align="center">
                                                                <table border="0" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td> <a href="{{ route('invoice-pay', $invoice_id) }}" target="_blank">Bayar Sekarang!</a> </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p style="margin: 14px 0;text-align:center">Atau Klik Tautan Dibawah<br /><a href="{{ route('invoice-pay', $invoice_id) }}" target="_blank">{{ route('invoice-pay', $invoice_id) }}</a></p>

                                                <!-- INVOICE DETAILS -->
                                                <table border="0" class="information" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td>Nama Pembeli</td>
                                                            <td>{{ "{$first_name} {$last_name}" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ID Tagihan</td>
                                                            <td>{{ $invoice_id }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumlah Yang Dibayar</td>
                                                            <td>{{ number_format($ammount, 2, ',', '.') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- END INVOICE DETAILS -->
                                                <p style="margin-bottom: 4px">Caranya pergi ke tautan diatas lalu klik Bayar Sekarang dan lakukan transaksi pada panel yang tertera. Jika sudah maka anda akan diarahkan ke halaman konfirmasi pembayaran dan tiket akan dikirmkan ke email anda.</p>
                                                <p style="padding-bottom: 24px; margin: 0;">Terima kasih</p>
                                                <p style="text-align: right;padding-bottom: 32px">Salam Hangat</p>
                                                <p style="text-align: right;padding-bottom: 0; margin: 0;">Hypenamic Event</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- END MAIN CONTENT AREA -->
                        </table>
                        <!-- START FOOTER -->
                        <div class="footer">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block" style="padding-bottom: 0; margin: 0">
                                        <span><a href="https://event.hypenamic.id">Hypenamic Event</a>, Jl. Pagesangan Asri 1 AA 51, Kelurahan Pagesangan, Kecamatan Jambangan, Kota Surabaya, Jawa Timur.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block powered-by" style="padding-top: 0; margin: 0">
                                        <span>Powered by <a href="https://www.hypenamic.id">Hypenamic Studio</a>.</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- END FOOTER -->
                        <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
