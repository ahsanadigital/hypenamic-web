@extends('templates.home')

@section('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
<style>
/* Header */
#main-title {
    background: #eee;
    background: url('{{ $event->event_banner ? asset($event->event_banner) : asset("assets/images/empty-state.png") }}') no-repeat center center;
    background-size: cover;
}
#banner {
    background: rgba(7, 5, 5, 0.5);
    min-height: 35vh;
}
#tabs {
    min-height: 10vh;
}

/* Tabs */
#main-title .nav .nav-link:not(.active) {
    color: var(--dark) !important;
}

/* Cards */
#buy-ticket {
    margin-top: -8rem;
}
@media screen and (max-width: 600px) {
    #buy-ticket {
        margin-top: 0;
    }
}

/* Breadcrumbs */
.bread-header .breadcrumb-item {
    color: white !important;
}
.bread-header .breadcrumb-item:after,
.bread-header .breadcrumb-item:before {
    color: rgba(255,255,255, .5);
}

/* Aturan */
#tos-collapse .card-header {
    font-weight: bold;
    color: var(--dark);
    text-decoration: none;
}

/** Option */
.option-wrapper {
    max-height: 500px;
    overflow-y: auto;
}
.option-wrapper .options:last-child {
    margin-bottom: 0;
}
label {
    width: 100%;
    font-size: 1rem;
}
label > * {
    transition: all .3s;
}
.card-input-element+.card {
    color: var(--dark);
    -webkit-box-shadow: none;
    box-shadow: none;
    transition: all .3s;
}
.card-input-element+.card:hover {
    cursor: pointer;
}
.card-input-element:checked+.card {
    border-color: var(--primary);
    background: rgba(72, 111, 255, .05);
    color: var(--primary);
    border-color: var(--primary);
    transition: all .3s;
}
.card-input-element+.card:hover {
    background: rgba(72, 111, 255, .05);
    color: var(--primary);
    border-color: var(--primary);
}

.inner-card {
    display: flex;
    align-items: stretch;
}
.inner-card .icon-wrapper {
    padding: 1rem;
    display: flex;
    background: var(--light);
    border-radius: .45rem 0 0 .45rem;
    align-items: center;
}
.card-input-element:checked+.card > .inner-card .icon-wrapper {
    background: var(--primary);
    color: white !important;
}
.inner-card .content-wrapper {
    padding: .5rem 1rem;
}

.card-input-element:disabled+.card:hover {
    cursor: not-allowed;
}
.card-input-element:disabled+.card .inner-card {
    opacity: .5;
}
.card-input-element:disabled+.card:hover {
    background: white;
    color: var(--dark);
    border-color: rgba(0,0,0,.125);
}

@-webkit-keyframes fadeInCheckbox {
    from {
        opacity: 0;
        -webkit-transform: rotateZ(-20deg);
    }

    to {
        opacity: 1;
        -webkit-transform: rotateZ(0deg);
    }
}
@keyframes fadeInCheckbox {
    from {
        opacity: 0;
        transform: rotateZ(-20deg);
    }

    to {
        opacity: 1;
        transform: rotateZ(0deg);
    }
}
</style>
@endsection

@section('container')
<section id="main-title">
    <div id="banner" class="text-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="text-center text-md-left">{{ $event->event_name }}</h1>
                    <p class="text-center text-md-left">{{ $event->event_desc_short }}</p>
                    <p class="text-center text-md-left"><i class="fas fa-user fa-fw mr-2"></i><a href="{{ route('organization-events.main', $author->username) }}" class="text-white">{{ $author->institution }}</a></p>
                    @if ($event->event_do === 'online')
                    <p class="text-center text-md-left"><i class="fas fa-map-marker fa-fw mr-2"></i><span class="badge badge-success">Event Online</span></p>
                    @else
                        @php
                        $kelurahan = $wilayah->getKelurahan($event->kecamatan, $event->kelurahan);
                        $kecamatan = $wilayah->getKecamatan($event->kabupaten, $event->kecamatan);
                        $kabupaten = $wilayah->getKabupaten($event->provinsi, $event->kabupaten);
                        $provinsi = $wilayah->getProvinsi($event->provinsi);
                        @endphp
                    <p class="text-center text-md-left"><i class="fas fa-map-marker fa-fw mr-2"></i>{{ $event->alamat ? $event->alamat . ', ' : '' }}{{ $kelurahan['nama'] }}, {{ $kecamatan['nama'] }}, {{ $kabupaten['nama'] }}, {{ $provinsi['nama'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<main id="container">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">

                <div class="pb-3 border-bottom mb-4">

                    <div class="row">
                        <div class="col-md-4 mt-n5 mt-md-0">
                            <img src="{{ $event->thumbnail ? asset($event->thumbnail) : asset('assets/images/icon-empty.png') }}" class="mb-3 mt-n5 mt-md-0 shadow rounded w-100" />
                            <div class="mb-3 mb-md-0">
                                <a class="btn btn-sm btn-primary" href="{{ $event->thumbnail ? asset($event->thumbnail) : asset('assets/images/icon-empty.png') }}" data-fancybox="gallery" data-caption="Ikon Kegiatan"><i class="fas fa-eye fa-fw mr-2"></i>Ikon</a>
                                <a class="btn btn-sm btn-primary" href="{{ $event->event_banner ? asset($event->event_banner) : asset('assets/images/empty-state.png') }}" data-fancybox="gallery" data-caption="Banner Kegiatan"><i class="fas fa-eye fa-fw mr-2"></i>Banner</a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3>Informasi Kegiatan</h3>
                            <div>{!! $event->event_desc !!}</div>

                            <div class="card my-3 table-responsive">
                                <table class="table-striped table m-0 table-borderless">
                                    <tr>
                                        <td>Penyelenggara</td>
                                        <td><a href="{{ route('organization-events.main', $author->username) }}">{{ $author->institution }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Kontak</td>
                                        <td>{{ $author->fullname }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $author->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Lengkap</td>
                                        <td>
                                            @php
                                            echo ($author->alamat ? "{$author->alamat}, " : '');

                                            if($author->kelurahan !== null && $author->kecamatan !== null) {
                                                echo "{$wilayah->getKelurahan($author->kecamatan, $author->kelurahan)['nama']}, ";
                                            }
                                            if($author->kecamatan !== null && $author->kecamatan !== null) {
                                                echo "{$wilayah->getKecamatan($author->kabupaten, $author->kecamatan)['nama']}, ";
                                            }
                                            if($author->provinsi !== null && $author->kabupaten !== null) {
                                                echo "{$wilayah->getKabupaten($author->provinsi, $author->kabupaten)['nama']}, ";
                                            }

                                            echo "{$wilayah->getProvinsi($author->provinsi)['nama']}";
                                            @endphp
                                        </td>
                                    </tr>
                                </table>

                                <div class="card-body">
                                    <div class="btn-group btn-group-sm">
                                    @if ($author->instagram)
                                        <a href="{{ $author->instagram }}" class="btn btn-primary"><i class="fab fa-facebook fa-fw"></i></a>
                                    @endif
                                    @if($author->facebook)
                                        <a href="{{ $author->facebook }}" class="btn btn-tertiary"><i class="fab fa-instagram fa-fw"></i></a>
                                    @endif
                                    @if($author->whatsapp)
                                        <a href="https://api.whatsapp.com/send?phone={{ $author->whatsapp }}" class="btn btn-success"><i class="fab fa-whatsapp fa-fw"></i></a>
                                    @endif
                                    @if($author->twitter)
                                        <a href="{{ $author->twitter }}" class="btn btn-info"><i class="fab fa-twitter fa-fw"></i></a>
                                    @endif
                                        <a href="mailto:{{ $author->email }}" class="btn btn-secondary"><i class="fas fa-envelope fa-fw"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3>Aturan Kegiatan</h3>
                    @if ($event->event_tos == null)
                    <div class="alert alert-color alert-info">
                        <div class="d-flex">
                            <i class="i fas fa-fw fa-5x fa-info-circle"></i>
                            <div class="right ml-3">
                                <h5>Nampaknya Belum Ada Apa-Apa</h5>
                                <p class="mb-0">Ups, maaf! Nampaknya tidak ada yang tersedia disini. Mohon hubungi pihak penyelenggara event ya?</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="tos-collapse">
                        @foreach (json_decode($event->event_tos) as $index => $tos)
                        <div class="card mb-2">
                            <a href="#" class="card-header rounded border-0 bg-white" id="heading-{{ $index }}" type="button" data-toggle="collapse" data-target="#collapse-{{ $index }}" aria-expanded="true" aria-controls="collapse-{{ $index }}">
                                <span>{{ $tos->title }}</span>
                            </a>

                            <div id="collapse-{{ $index }}" class="collapse{{ $index == 0 ? ' show' : '' }}" aria-labelledby="heading-{{ $index }}" data-parent="#tos-collapse">
                                <div class="card-body">
                                @php
                                    echo str_replace(['<script>', '</script>'], ['&lt;script&gt;', '&lt;/script&gt;'], $tos->desc);
                                @endphp
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

            </div>
            <form action="{{ route('cart.addition') }}" method="POST" id="cart-addition" class="col-md-4 mt-md-n5">
                @csrf

                <div class="card mt-md-n5 card-body border-0">
                    <h3>Pilih Tiketnya</h3>
                @if($event->status == 'open' && \Carbon\Carbon::now()->timestamp <= \Carbon\Carbon::parse($event->end_date)->timestamp)
                    @if ($event->ticketsEvent()->orderBy('price', 'ASC')->count() > 0)
                    <div class="option-wrapper">
                        <input type="hidden" name="name" id="name" />
                        <input type="hidden" name="price" id="price" />

                        @foreach ($event->ticketsEvent()->orderBy('price', 'ASC')->get() as $data)
                        <label class="options">
                            <input type="radio" name="id_ticket" class="card-input-element d-none" {{ $data->stok == '0' ? 'disabled ' : '' }}id="trigger" value="{{ $data->id_ticket }}" data-stok="{{ $data->stok }}" data-price="{{ $data->price }}" data-name="{{ $data->ticket_name }}" />
                            <div class="card">

                                <div class="inner-card">
                                    <div class="icon-wrapper">
                                        <i class="fa-ticket-alt fa-fw fas"></i>
                                    </div>
                                    <div class="content-wrapper">
                                        <h5 class="m-0">{{ $data->ticket_name }}</h5>
                                        <div class="d-flex mb-2">
                                            <span class="badge badge-success">{!! ($data->price > 0 ? "Rp" . number_format($data->price, 2, ',', ',') : 'Gratis') !!}</span>
                                            @if ($data->stok > 0)
                                            <p class="m-0 badge badge-primary">{{ $data->stok }} Tiket</p>
                                            @else
                                            <p class="m-0 badge badge-danger">Stok Habis!</p>
                                            @endif
                                        </div>
                                        <p class="m-0">{{ $data->description_tiket }}</p>
                                    </div>
                                </div>

                            </div>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-color alert-info m-0">
                        <div class="d-flex">
                            <i class="fas fa-3x fa-info-circle fa-fw"></i>
                            <div class="container-c ml-3">
                                <h3 class="h5">Maaf, Tiket belum tersedia!</h3>
                                <p class="m-0">Silahkan hubungi penyelenggara.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="collapse" id="submit-toggle">
                        <div class="form-group my-3">
                            <label>Jumlah Tiket Yang Akan Dibeli</label>
                            <div class="d-flex align-items-center">
                                <button data-toggle="decrease" type="button" class="btn btn-primary btn-sm"><i class="fas fa-minus fa-fw"></i></button>
                                <input type="text" class="form-control-plaintext px-2" value="0" id="value" name="value" placeholder="Masukkan jumlah tiket yang dibeli" readonly="readonly" />
                                <button data-toggle="increase" type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-fw"></i></button>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block" disabled type="submit">Pesan Sekarang!</button>
                    </div>
                @else
                    <div class="card shadow card-body mt-n5 mb-3 border-0">
                        <div class="alert alert-color alert-info m-0">
                            <div class="d-flex">
                                <i class="fas fa-3x fa-info-circle fa-fw"></i>
                                <div class="container-c ml-3">
                                    <h3 class="h5">Maaf, Event Sudah Berakhir</h3>
                                    <p class="m-0">Maaf, event ini sudah berkahir dan pendaftaranya telah ditutup oleh penyelenggara.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<script>
"use strict";

// Change Ticket
$('#trigger').click(function() {
    let el = $('#trigger:checked');

    $('#name').val(el.data('name'));
    $('#price').val(el.data('price'));
});
// Change Ticket

// Change Value
$('[name="id_ticket"]').change(function() {
    let el = $('#trigger:checked');
    if(el.length > 0) {
        $('#submit-toggle').collapse('show');
    } else {
        $('#submit-toggle').collapse('hide');
    }
});

$('[data-toggle="increase"]').click(function() {
    let el   = $('#trigger:checked');
    let val  = $('#value');
    let inp  = parseInt(val.val());
    let stok = parseInt(el.data('stok'));

    if(el.length > 0) {
        if(inp >= stok) {
            warnAlert.fire({
                title: 'Woops!',
                text: 'Jumlah tiket yang anda beli sudah melebihi stok yang tersisa!',
                icon: 'warning',
            });
        } else if(inp >= 5) {
            warnAlert.fire({
                title: 'Woops!',
                text: 'Jumlah tiket maksimal yang dapat anda tambahkan adalah 5 tiket sekali beli!',
                icon: 'warning',
            });
        } else {
            $('form button[type="submit"]').prop({'disabled' : false});

            let input = inp + 1;
            val.val(input);
        }
    } else {
        warnAlert.fire({
            title: 'Woops!',
            text: 'Pilih salah satu tiket yang tersedia dulu ya sebelum menambah berapa tiket ayng akan anda beli...',
            icon: 'warning',
        });
    }
});

$('[data-toggle="decrease"]').click(function() {
    let val  = $('#value');
    let inp  = parseInt(val.val());

    if(inp > 0) {
        let input = inp - 1;
        val.val(input);
        $('form button[type="submit"]').prop({'disabled' : false});
        if(inp == 1) {
            $('form button[type="submit"]').prop({'disabled' : true});
        }
    }
});
// Change Value

// Submit
$('form#cart-addition').submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: $(this).serialize(),

        beforeSend() {
            Swal.fire({
                title: 'Menambahkan Dahulu...',
                text: 'Sedang menambahkan pembelian ke keranjang belanjaan anda',
                allowOutsideClick: false,
                didOpen() {
                    Swal.showLoading()
                },
            });
        },
        success(e) {
            successAlert.fire({
                icon: 'success',
                text: e.message,
                title: e.title,
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            setTimeout(() => {
                window.location.href = e.redirect;
            }, 2500);
        },
        error(error) {
            let res = error.responseJSON;
            warnAlert.fire({
                title: res.title ? res.title : 'Ada Kesalahan!',
                text: res.message ? res.message : 'Woops, maaf! Ada kesalahan teknis disini. Silahkan coba lagi beberapa saat! Jika masih ada kendala yang sama mohon hubungi admin yang ada di bagian footer web ini ya?',
                icon: 'error',
            });
        }
    });
});
// Submit
</script>
@endsection
