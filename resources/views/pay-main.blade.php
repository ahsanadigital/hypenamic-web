@extends('templates.invoice')

@section('container')
<div class="container">
    <div class="row justify-content-center min-vh-100 py-5 align-items-center">
        <div class="col-md-5">
            <div class="card shadow text-center card-body border-0">
                <a href="{{ route('home') }}" class="d-block w-100 mb-5">
                    <img src="{{ asset('assets/images/brands/hypenamic-event-color.png') }}" height="90px" class="p-2 mb-n5 mt-n5 mx-auto d-block">
                </a>

                <h3>Cek Pembayaran</h3>
                <p>Cek status pembayaran anda apabila anda sudah membayar tagihan yang sudah dikirimkan ke email anda.</p>

                <form action="{{ route('invoice-check') }}" method="GET">
                    <input type="text" class="form-control" id="id_tagihan" name="id_tagihan" placeholder="Silahkan masukkan kode tagihan anda" />

                    <button type="submit" class="mt-3 btn btn-block bayar btn-primary"><i class="fas fa-money-bill-alt mr-2 fa-fw"></i>Cek Tagihan</button type="button">
                    <a href="{{ route('home') }}" class="btn btn-block btn-light"><i class="fas fa-arrow-left mr-2 fa-fw"></i>Kembali</a>
                </form>
            </div>

            <div class="d-block mx-auto mt-3">
                <p class="text-center m-0">Hak Cipta {{ now()->format('Y') }}, <a href="{{ route('home') }}">{{ config('app.name') }}</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
