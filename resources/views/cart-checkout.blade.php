@extends('templates.home')

@section('header')
<style>
#masthead {
    background: url('{{ asset("assets/images/header.jpg") }}') no-repeat center center;
    background-position: 50% auto;
    background-size: cover;
}
#masthead .inner-overlay {
    min-height: 25vh;
    background: rgba(0,0,0,.25);
}

/* Breadcrumbs */
.bread-header .breadcrumb-item {
    color: white !important;
}
.bread-header .breadcrumb-item:after,
.bread-header .breadcrumb-item:before {
    color: rgba(255,255,255, .5);
}
</style>
@endsection

@section('container')
<header id="masthead">
    <div class="inner-overlay">
        <div class="container text-white py-5">
            <h1 class="text-center text-md-left">Selesaikan Pemesanan Tiket</h1>
            <nav class="breadcrumb justify-content-md-start justify-content-center bread-header bg-transparent px-0 ">
                <a href="{{ route('home') }}" class="breadcrumb-item breadcrumb-link">Beranda</a>
                <span class="breadcrumb-item breadcrumb-link active">Checkout</span>
            </nav>
        </div>
    </div>
</header>

@if (!empty($cart) && !empty($ticket))
<form action="{{ route('cart.process') }}" method="POST" class="mb-5 pt-5 container">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="alert alert-color alert-info">
                <div class="d-flex">
                    <i class="fas fa-fw fa-5x fa-info-circle"></i>
                    <div class="content ml-3">
                        <h3>Data Dirimu Aman</h3>
                        <p class="m-0">Tenang, data diri yang kamu masukkan tidak akan kami sebarluaskan dan akan tetap aman dalam database kami. Semua isian dibawah ini digunakan untuk informasi transaksi dan juga informasi pembayaran akan dikirimakn oleh sistem ke email anda.</p>
                    </div>
                </div>
            </div>

            <div class="card card-body bg-warning text-white mb-3">
                <span class="d-inline">Selesaikan pemesanan dalam waktu <span id="time"></span> menit!</span>
            </div>

            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="first_name">Nama Depan</label>
                        <input type="text" id="first_name" placeholder="Masukkan nama lengkap anda" name="first_name" class="form-control" />
                        <div class="error-message"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input type="text" id="last_name" placeholder="Masukkan nama lengkap anda" name="last_name" class="form-control" />
                        <div class="error-message"></div>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-group">
                <label for="email">Email/Surat Elektronik</label>
                <input type="email" class="form-control" placeholder="Masukkan email anda" name="email" />
                <div class="error-message"></div>
            </div>

            <div class="mb-3 form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="text" class="form-control" placeholder="Masukkan nomor HP anda" id="nomor_hp" name="nomor_hp" />
                <div class="error-message"></div>
            </div>

            @if($cart['price'] * $cart['value'] > 0)
            <hr />
            <h3 class="text-center">Pembayaran Melalui</h3>
            <div class="row">
                <div class="col-6 col-md-3 mb-3">
                    <div class="card card-body">
                        <img src="{{ asset('assets/images/payment/akulaku.png') }}" alt="Akulaku Payment" loading="lazy" />
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card card-body">
                        <img src="{{ asset('assets/images/payment/alfamart.png') }}" alt="Alfamart Payment" loading="lazy" />
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card card-body">
                        <img src="{{ asset('assets/images/payment/indomaret.png') }}" alt="Indomaret Payment" loading="lazy" />
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card card-body">
                        <img src="{{ asset('assets/images/payment/bank-transfer.jpg') }}" alt="Bank Transfer" loading="lazy" />
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card card-body">
                        <img src="{{ asset('assets/images/payment/gopay_v2.png') }}" alt="Gopay Payment" loading="lazy" />
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card card-body">
                        <img src="{{ asset('assets/images/payment/visa-mastercard-logo.jpg') }}" alt="CC Payment" loading="lazy" />
                    </div>
                </div>
            </div>

            <hr />

            <div class="d-none d-md-none d-lg-block">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="agreements" name="agreements" />
                        <label class="custom-control-label" for="agreements">Saya menyetujui <a href="">Aturan dan Regulasi</a>.</label>
                    </div>
                    <div class="error-message"></div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Bayar Sekarang</button>
            </div>
            @else

            <hr />

            <div class="d-none d-md-none d-lg-block">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="agreements" name="agreements" />
                        <label class="custom-control-label" for="agreements">Saya menyetujui <a href="">Aturan dan Regulasi</a>.</label>
                    </div>
                    <div class="error-message"></div>
                </div>

                @if($cart['price'] > 0)
                <button type="submit" class="btn btn-primary btn-block">Bayar Sekarang</button>
                @else
                <button type="submit" class="btn btn-primary btn-block">Proses Sekarang</button>
                @endif
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5>Pembelian Anda</h5>
                    <p>Harap dicek terlebih dahulu pesanan anda.</p>

                @if($cart['price'] > 0)
                    @php
                    $value      = $cart['value'] < $ticket->stok ? $ticket->stok : $cart['value'];
                    $bea        = 5500;
                    $price      = $cart['price'];

                    $per        = $price;
                    $subtotal   = $per * $value;
                    $pajak      = $subtotal * 0.1;
                    $total      = $pajak + $subtotal + $bea;
                    @endphp
                @else
                    @php
                    $value      = $cart['value'] < $ticket->stok ? $ticket->stok : $cart['value'];
                    $bea        = 5500;
                    $price      = $cart['price'];

                    $per        = $price + $bea * 0;
                    $subtotal = $per * $value;
                    $pajak      = $subtotal * 0.1;
                    $total      = $pajak + $subtotal;
                    @endphp
                @endif

                    <input type="hidden" name="ammount" value="{{ $total }}" />
                    <input type="hidden" name="id_ticket" value="{{ $cart['id_ticket'] }}" />

                    <strong>Pembelian</strong>
                    <p class="m-0">Tiket <strong>{{ $cart['name'] }}</strong> pada event <strong>{{ $ticket->getEvent()->select(['event_name'])->first()->event_name }}</strong></p>
                </div>
                <ul class="list-group border-top list-group-flush">
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div class="col-7">
                                <h6 class="my-0"><strong>{{ $cart['name'] }}</strong> x {{ $cart['value'] < $ticket->stok ? $ticket->stok : $cart['value'] }}</h6>
                                <small class="text-muted">{{ $ticket->getEvent()->select(['event_name'])->first()->event_name }}</small>
                            </div>
                            <div class="col-5 text-muted text-right">{{ $helper->thousandsCurrencyFormat($price) }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div class="col-7">
                                <h6 class="my-0">Biaya Layanan</h6>
                                <small class="text-muted">Per Transaksi</small>
                            </div>
                            <div class="col-5 text-muted text-right">{{ $helper->thousandsCurrencyFormat($bea) }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div class="col-7">
                                <h6 class="my-0">Bea Pajak</h6>
                                <small class="text-muted">Dari Subtotal</small>
                            </div>
                            <div class="col-5 text-muted text-right">{{ $helper->thousandsCurrencyFormat($pajak) }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row justify-content-between">
                            <div class="col-7">
                                <h6 class="my-0">Total</h6>
                                <small class="text-muted">Semua Pesanan Anda</small>
                            </div>
                            <div class="col-5 text-muted text-right"><h6>{{ $helper->thousandsCurrencyFormat($total) }}</h6></div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="d-lg-none mt-3">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="agreements" name="agreements" />
                        <label class="custom-control-label" for="agreements">Saya menyetujui <a href="{{ route('tos') }}">Aturan dan Regulasi</a>.</label>
                    </div>
                    <div class="error-message"></div>
                </div>

                @if($cart['price'] > 0)
                <button type="submit" class="btn btn-primary btn-block">Bayar Sekarang</button>
                @else
                <button type="submit" class="btn btn-primary btn-block">Proses Sekarang</button>
                @endif
            </div>
        </div>
    </div>
</form>
@else
<section class="container mt-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-md-6">
            <div class="bg-primary card">
                <div class="card-body text-white">
                    <div class="row">
                        <div class="col-6 col-md-3 mb-3">
                            <i class="fas fa-5x fa-fw fa-info-circle"></i>
                        </div>
                        <div class="col-9">
                            <h4>Informasi</h4>
                            <p>Maaf, saat ini keranjang anda masih kosong. Silahkan pesan satu tiket dahulu ke halaman event yang ada pada tombol dibawah ini.</p>
                            <a href="{{ route('jelajah') }}" class="btn btn-warning"><i class="fas fa-compass fa-fw mr-2"></i>Jelajahi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('footer')
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/localization/messages_id.js') }}"></script>

<script>
"use strict";

$('form').validate({
    rules: {
        first_name: {
            required: true,
        },
        last_name: {
            required: true,
        },
        email: {
            required: true,
            email: true,
        },
        nomor_hp: {
            required: true,
        },
        agreements: {
            required: true,
        }
    },

    messages: {
        agreements: 'Anda harus menyetujui Aturan dan regulasinya dahulu! Harap dibaca terlebih dahulu...',
    },

    onfocusout: function (e) {
        this.element(e);
    },

    highlight: function (element) {
        jQuery(element).closest('.form-control').addClass('is-invalid');
        jQuery(element).closest('.form-control').removeClass('is-valid');
    },
    unhighlight: function (element) {
        jQuery(element).closest('.form-control').removeClass('is-invalid');
        jQuery(element).closest('.form-control').addClass('is-valid');
    },

    errorElement: 'div',
    errorClass: 'invalid-feedback',
    errorPlacement: function (error, element) {
        $(element).parents('.form-group').find(".error-message").append(error);
    },

    submitHandler(e) {
        Swal.fire({
            title: 'Memproses...',
            text: 'Sedang memproses permintaan anda.',
            allowEscapeKey : false,
            allowOutsideClick: false,
            didOpen() {
                Swal.showLoading()
            },
        });
        e.submit();
        localStorage.removeItem(minutes);
    }
});

let waktu = parseInt(localStorage.getItem('minutes') ? localStorage.getItem('minutes') : 60 * 15);
setTimeout(() => {
    localStorage.removeItem(minutes);
    window.location.href = '{{ route('cart.truncate') }}';
}, waktu);
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        let times = (minutes * 60) + seconds;
        localStorage.setItem('minutes', times);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}
window.onload = function () {
    let timers  = waktu;
    var minutes = timers,
        display = document.querySelector('#time');
    startTimer(minutes, display);
};
// Submit ========================================================
</script>
@endsection
