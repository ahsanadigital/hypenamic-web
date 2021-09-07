@extends('templates.home')

@section('header')
<style>
/* Modal Search */
.searching-header {
    display: flex;
    justify-content: space-between;
}
.searching-body .searching-item {
    padding: 1rem;
    border-color: #eeeeee;
    color: var(--dark);
    display: block;
    text-decoration: none;
    border-radius: .5rem;
    margin: 0 0 .5rem 0;
    border: 1px solid transparent;
    transition: all .2s;
}
.searching-body .searching-item:hover {
    background: rgba(72, 111, 255, .1);
    border-color: var(--primary);
}
.searching-body .searching-item:focus {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

/* Category Lists */
.category-lists {
    display: inline-block;
    padding: .25rem .75rem;
    border-radius: .5rem;
    border: 1px solid rgb(216, 216, 216);
    color: var(--dark);
    outline: 0;
    text-decoration: none!important;
    transition: all .2s;
}
.category-lists:hover {
    background: rgba(21, 71, 255, .1);
    color: var(--primary);
    border-color: var(--primary);
}
.category-lists:focus,
.category-lists.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}
</style>
@endsection

@section('container')
<main class="py-5">
    <div class="container">

        <!-- Heading Side -->
        <nav>
            <ul class="px-0 mb-0 breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb-link">Beranda</a></li>
                <li class="breadcrumb-item active"><span class="active breadcrumb-link">Event</span></li>
            </ul>
        </nav>
        <div class="d-flex justify-content-between mb-3">
            <h1>Event</h1>

            <div class="right-side">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
                    <i class="fas fa-search mr-2 fa-fw"></i><span>Cari Event</span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalLabel">Cari Event</h5>
                                <button type="button" class="btn-modal-close close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="modal-search" action="{{ route('jelajah.api-search') }}">
                                    @csrf

                                    <div class="form-group mb-0 row">
                                        <div class="col-7 col-md-9">
                                            <input type="text" class="form-control" name="search" id="search" placeholder="Ketikkan nama event lalu tekan &quot;enter&quot;" />
                                        </div>
                                        <div class="col-md-3 col-5">
                                            <button class="btn btn-block btn-primary"><i class="fas mr-2 fa-search"></i><span>Cari</span></button>
                                        </div>
                                    </div>
                                </form>

                                <div class="collapse" id="loading-bar">
                                    <div class="progress mt-3">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                </div>

                                <div class="collapse" id="search-warapper">

                                    <div class="searching-header pt-3">
                                        <p class="h5">Menunjukkan Hasil Pencarian</p>
                                        <span class="search-result"></span>
                                    </div>
                                    <div class="searching-body"></div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-modal-close btn-primary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Looping -->
        <div class="mb-3">
        @if ($category->count() > 0)
            @foreach ($category->get() as $data)
            <a href="{{ route('jelajah.kategori', $data->slug) }}" class="category-lists mb-2">{{ $data->cat_name }}</a>
            @endforeach
        @else
            <div class="alert alert-color alert-info">
                <div class="row">
                    <div class="col-3">
                        <i class="fas fa-info-circle fa-fw fa-5x"></i>
                    </div>
                    <div class="col-9">
                        <h4>Tidak ada kategori</h4>
                    </div>
                </div>
            </div>
        @endif
        </div>

        <!-- Main List of Events -->
        <article class="event-lists">
            @if (!empty($events->count()) == 0)
            <div id="empty-state" class="d-flex align-items-center mt-4 flex-column text-center justify-content-center">
                <img loading="lazy" src="{{ asset('assets/images/not-found.svg') }}" alt="Not Found" height="250px" />
                <h3 class="my-3">Maaf, Belum Ada Event Apapun!</h3>
                <p class="text-muted">Ups, maaf ya? Kali ini belum ada event apapun yang digelar dan dipaparkan disini. Jika anda berminat untuk menggelar event, silahkan klik tombol dibawah ini.</p>
                <a href="{{ route('user.register') }}" class="btn btn-warning btn-lg"><i class="fas fa-user-plus fa-fw mr-2"></i><span>Daftar Sekarang!</span></a>
            </div>
            @else
            <div class="row">
                @foreach ($events as $giat)
                <div class="col-lg-3 col-md-4 col-12 mb-3">
                    <div class="card shadow border-0">
                        @if (!empty($giat->event_banner))
                        <img loading="lazy" src="{{ asset($giat->event_banner) }}" alt="Image Heading" class="card-img-top" />
                        @else
                        <img loading="lazy" src="{{ asset('assets/images/empty-state.png') }}" alt="Hypenamic Event by Hypenamic Studio" class="card-img-top" />
                        @endif
                        <div class="card-body">
                            <h3 class="h5"><a class="text-dark" href="{{ route('jelajah.show', $giat->event_id) }}">{{ $giat->event_name }}</a></h3>

                            <div class="mb-3">
                            @if($giat->event_type == 'free')
                                <span class="badge badge-success">Event Gratis!</span>
                            @elseif($giat->event_type == 'bayar' && $giat->ticketsEvent()->count() == 0)
                                <span class="badge badge-warning">Tiket Belum Tersedia!</span>
                            @elseif($giat->event_type == 'bayar' && $giat->ticketsEvent()->count() > 0)
                                @php
                                $price = $giat->ticketsEvent()->orderBy('price', 'ASC')->select(['price'])->first();
                                $show  = $helper->thousandsCurrencyFormat($price->price );
                                @endphp

                                <p class="mb-0">Harga Tiket Mulai</p>
                                <p class="h4">{{ $show }}</p>
                            @endif
                            </div>

                            <ul class="list-unstyled mb-0">
                                <li><i class="fas fa-map-marker-alt fa-fw mr-2 text-danger"></i>{{ $giat->event_do == 'offline' ? "{$wilayah->getKabupaten($giat->provinsi, $giat->kabupaten)['nama']}, {$wilayah->getProvinsi($giat->provinsi)['nama']}" : 'Online' }}</li>
                                <li><i class="fas fa-calendar fa-fw mr-2"></i>{{ $carbon->parse($giat->start_date)->isoFormat('D MMMM Y') }} &mdash; {{ $carbon->parse($giat->end_date)->isoFormat('D MMMM Y') }}</li>
                                <li><i class="fas fa-clock mr-2 fa-fw"></i>{{ $giat->start_time }} &mdash; {{ $giat->end_time }}</li>
                            </ul>
                        </div>

                        @php
                            $data = $giat->getUsers();
                        @endphp

                        @if ($data->count() == 0)
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <div class="left">
                                    <img loading="lazy" src="{{ asset('assets/images/user.png') }}" alt="" class="w-100 rounded-circle" style="max-width: 25px; max-height: 25px" />
                                </div>
                                <div class="right ml-3">
                                    <h3 class="h6 mb-0">Anonymous Person</h3>
                                </div>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('organization-events.main', $data->first()->username) }}" class="card-footer bg-white">
                            <div class="d-flex align-items-center">
                                <div class="left">
                                    @if($data->first()->foto_profil == null)
                                    <img loading="lazy" src="{{ asset('assets/images/user.png') }}" alt="" class="w-100 rounded-circle" style="max-width: 25px; max-height: 25px" />
                                    @else
                                    <img loading="lazy" src="{{ asset($data->first()->foto_profil) }}" alt="" class="rounded-circle" style="max-width: 25px; max-height: 25px" />
                                    @endif
                                </div>
                                <div class="right ml-3">
                                    <h3 class="h6 mb-0">{{ $data->first()->institution }}</h3>
                                </div>
                            </div>
                            @php
                                unset($data);
                            @endphp
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{ $events->links('pagination.discover-pagination') }}
            @endif
        </article>

    </div>
</main>
@endsection

@section('footer')
<script>
"use strict";

$('.btn-modal-close').click(function() {
    $('.searching-body').html('');
    $('#loading-bar').collapse('hide');
    $('#search-warapper').collapse('hide');
    $('#search').val('').prop({'disabled': false});
});
$('#searchModal').on('hidden.bs.modal', function() {
    $('.searching-body').html('');
    $('#loading-bar').collapse('hide');
    $('#search-warapper').collapse('hide');
    $('#search').val('').prop({'disabled': false});
});

$('#modal-search').submit(function(e) {
    e.preventDefault();

    $.ajax(
        {
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),

            beforeSend() {
                $('#search, button[type="submit"]').prop({'disabled': true});
                $('#loading-bar').collapse('show');
                $('#search-warapper').collapse('hide');
            },
            success(e) {
                $('#loading-bar').collapse('hide');
                $('#search-warapper').collapse('show');
                $('#search, button[type="submit"]').prop({'disabled': false});

                let data = e.data;
                let html = '';

                $('.search-result').html(`${e.count} Data`);

                if(data.length > 0) {
                    for(let i = 0; i < data.length; i++) {
                        html += `<a href="{{ url('/event/details') }}/${data[i].events.event_id}" class="searching-item">`;
                            html += `<p class="h4 mb-3">${data[i].events.event_name}</p>`;
                            if(data[i].events.event_type == 'free') {
                                html += `<p><span class="badge badge-success">Gratis!</span></p>`;
                            } else if(data[i].events.event_type == 'bayar' && data[i].price === null) {
                                html += `<p><span class="badge badge-warning">Tiket Belum Tersedia!</span></p>`;
                            } else if(data[i].events.event_type == 'bayar' && data[i].price.price) {
                                let price = data[i].price.price;
                                html += `<p class="h6 mb-1">Harga Tiket Mulai</p><p><span class="mb-1 badge badge-primary">IDR${price.toLocaleString('id', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span></p>`;
                            }
                            html += `<ul class="list-unstyled mb-0">`;
                                html += `<li><i class="fas fa-calendar fa-fw mr-2"></i>${moment(data[i].events.start_date).format('LL')} - ${moment(data[i].events.end_date).format('LL')}</li>`;
                                html += `<li><i class="fas fa-clock mr-2 fa-fw"></i>${moment(data[i].events.start_date + ' ' + data[i].events.start_time).format('H.mm')} - ${moment(data[i].events.end_date + ' ' + data[i].events.end_time).format('H.mm')}</li>`;
                            html += `</ul>`;
                        html += `</a>`;
                    }
                } else {
                    html += `<div class="alert alert-info">Event yang anda cari tidak ada.</div>`;
                }
                $('.searching-body').html(html);
            },
            error(e) {
                console.log(e)
                $('#loading-bar').collapse('hide');
                $('#search-warapper').collapse('show');
                $('#search').prop({'disabled': false});
            }
        }
    );
});
</script>
@endsection
