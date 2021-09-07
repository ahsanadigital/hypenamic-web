@extends('templates.invoice')

@section('container')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-5">
            <div class="card shadow card-body border-0">
                <a href="{{ route('home') }}" class="d-block w-100 mb-5">
                    <img src="{{ asset('assets/images/brands/hypenamic-event-color.png') }}" height="90px" class="p-2 mb-n5 mt-n5 mx-auto d-block">
                </a>

                <h3 class="text-center">Transaksi Gagal!</h3>
                <p class="text-center">Transaksi anda telah dibatalkan, gagal atau kadaluarsa.</p>

                <a href="{{ route('home') }}" class="btn btn-block btn-primary"><i class="fas fa-arrow-left mr-2 fa-fw"></i>Kembali</a>
            </div>

            <div class="d-block mx-auto mt-3">
                <p class="text-center m-0">Hak Cipta {{ now()->format('Y') }}, <a href="{{ route('home') }}">{{ config('app.name') }}</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
