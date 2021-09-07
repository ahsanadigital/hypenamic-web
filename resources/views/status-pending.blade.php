@extends('templates.invoice')

@section('container')
<div class="container">
    <div class="row justify-content-center min-vh-100 py-5 align-items-center">
        <div class="col-md-5">
            <div class="card shadow card-body border-0">
                <a href="{{ route('home') }}" class="d-block w-100 mb-5">
                    <img src="{{ asset('assets/images/brands/hypenamic-event-color.png') }}" height="90px" class="p-2 mb-n5 mt-n5 mx-auto d-block">
                </a>

                <h3 class="text-center">Transaksi Berhasil</h3>
                <p class="text-center">Transaksi anda telah berhasil terekam oleh database Midtrans, namun status pembayaran anda adalah.</p>

                <div class="alert alert-warning">
                    <h3 class="text-center m-0">Pending</h3>
                </div>

                <p class="text-center">Jika merasa sudah membayar dan mengirimkan sejumlah uang kepada sistem midtrans, silahkan klik tautan dibawah.</p>

                <a href="{{ route('invoice-check') }}?id_tagihan={{ $input['order_id'] }}" class="btn btn-block btn-primary"><i class="fas fa-sync fa-fw mr-2"></i>Cek Pembayaran</a>
                <a href="{{ route('invoice-main') }}" class="btn btn-block btn-light"><i class="fa fa-arrow-left fa-fw mr-2"></i>Kembali</a>
            </div>

            <div class="d-block mx-auto mt-3">
                <p class="text-center m-0">Hak Cipta {{ now()->format('Y') }}, <a href="{{ route('home') }}">{{ config('app.name') }}</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
