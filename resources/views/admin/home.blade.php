@extends('templates.admin')

@section('container')
<header id="mainhead" class="mb-3">
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-md-8 text-center text-md-left mb-md-0 mb-3">
                <p class="text-muted">Selamat Datang Kembali</p>
                <h2>{{ auth()->user()->fullname }}!</h2>
                <p class="m-0 text-muted">Berikut kami sajikan beberapa informasi keseluruhan data pembelian dalam beberapa hari terakhir.</p>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center p-3 rounded" style="border: 1px solid rgba(255,255,255, .3)">
                            <h3>36jt</h3>
                            <p class="m-0">Pembelian</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 rounded" style="border: 1px solid rgba(255,255,255, .3)">
                            <h3>36jt</h3>
                            <p class="m-0">Pembelian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="main-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-body"></div>
            </div>
            <div class="col-md-6">
                <div class="card card-body"></div>
            </div>
        </div>
    </div>
</section>
@endsection
