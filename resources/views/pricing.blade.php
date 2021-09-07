@extends('templates.home')

@section('container')
<section class="py-5">
    <div class="container py-5">

        <h3 class="mb-3 text-center">Daftar Harga Layanan</h3>

        <div class="row">
            <div class="col-md-4">
                <h3>Layanan Tiket Online/Offline</h3>
                <p>Berikut ketentuan dan daftar harga layanan penyewaan sistem tiket online.</p>
            </div>
            <div class="col-md-8">

                <div class="table-responsive card p-0 m-0">
                    <table class="table m-0 border-none">
                        <thead>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <th>Layanan</th>
                                <th>Biaya Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-top-0">Virtual Account (Rekening Bank Virtual)</td>
                                <td class="border-top-0"><img src="{{ asset('assets/images/payment/bank.png') }}" alt="Rekening Bank" class="w-100"></td>
                                <td class="border-top-0">Harga Tiket + Rp 4.500,-</td>
                            </tr>
                            <tr>
                                <td>Kartu Kredit</td>
                                <td><img src="{{ asset('assets/images/payment/cc.png') }}" alt="Kartu Kredit" class="w-100"></td>
                                <td>Harga Tiket * 2,9% + Rp 2.000,-</td>
                            </tr>
                            <tr>
                                <td>Dompet Digital</td>
                                <td><img src="{{ asset('assets/images/payment/wallet.png') }}" alt="Dompet Digital" class="w-100"></td>
                                <td>Harga Tiket * 1,5%</td>
                            </tr>
                            <tr>
                                <td>Qris Payment</td>
                                <td><img src="{{ asset('assets/images/payment/qris.png') }}" alt="Qris" class="w-100"></td>
                                <td>Harga Tiket * 0,7%</td>
                            </tr>
                            <tr>
                                <td>Supermarket dan Retail</td>
                                <td><img src="{{ asset('assets/images/payment/ritel.png') }}" alt="Supermarket" class="w-100"></td>
                                <td>Harga Tiket * 0,7%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
