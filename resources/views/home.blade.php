@extends('templates.home')

@section('header')
<link rel="stylesheet" href="{{ asset('vendor/owl-carousel/assets/owl.carousel.min.css') }}">

<style>
.card-alt {
    padding: .5rem 1rem;
    position: absolute;
    width: 100%;
    border-radius: .5rem .5rem 0 0;
    background: linear-gradient(180deg, #868686, transparent);
}

.owl-carousel .owl-nav .owl-prev,
  .owl-carousel .owl-nav .owl-next,
  .owl-carousel .owl-dot {
    font-family: 'fontAwesome';

}
.owl-carousel .owl-nav .owl-prev:before{
    // fa-chevron-left
    content: "\f053";
    margin-right:10px;
}
.owl-carousel .owl-nav .owl-next:after{
    //fa-chevron-right
    content: "\f054";
    margin-right:10px;
}
</style>
@endsection

@section('container')

    <header class="owl-carousel">
        @if ($highlight->count() > 0)
            @foreach ($highlight->get() as $event)
            <div class="bg-dark text-white" id="banner-bottom" style="background: url('{{ $event->event_banner ? asset($event->event_banner) : asset("assets/images/empty-state.png") }}') no-repeat center center;background-size: cover;">
                <div class="py-5 d-flex align-items-center" style="min-height: 65vh;background: rgba(0,0,0,.75)">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <h1 class="text-center text-md-left">{{ $event->event_name }}</h1>
                                <p class="text-center text-md-left">{!! $event->event_desc !!}</p>
                                @php
                                    $author = $event->getUsers()->first();
                                @endphp
                                <p class="text-center text-md-left"><i class="fas fa-user fa-fw mr-2"></i><a href="{{ route('organization-events.main', $author->username) }}" class="text-white">{{ $author->institution }}</a></p>
                                @if ($event->event_do === 'online')
                                <p class="text-center text-md-left"><i class="fas fa-map-marker fa-fw mr-2"></i><span class="badge badge-success">Event Online</span></p>
                                @else
                                    @php
                                    $kabupaten = $wilayah->getKabupaten($event->provinsi, $event->kabupaten);
                                    $provinsi = $wilayah->getProvinsi($event->provinsi);
                                    @endphp
                                <p class="text-center text-md-left"><i class="fas fa-map-marker fa-fw mr-2"></i>{{ $kabupaten['nama'] }}, {{ $provinsi['nama'] }}</p>
                                @endif

                                <a href="{{ route('jelajah.show', $event->event_id) }}" class="btn btn-warning">Selengkapnya<i class="fas ml-2 fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        <div class="py-5 bg-dark text-white d-flex align-items-center" id="banner-bottom" style="min-height: 65vh;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 style="font-size: 2.25rem">Buat Eventmu Dengan Mudah!</h1>
                        <p style="font-size: 1.25rem">Mau buat sebuah kegiatan dan bingung soal pemasaran dan pendistribusian tiket? Yuk gabung ke <strong>Hypenamic Event</strong> yang siap membantu anda untuk memasarkan dan mendistribusikan tiket kegiatan kamu!</p>

                        <a href="/register" class="btn text-dark btn-lg btn-warning">Buat Eventmu!</a>
                    </div>
                    <div class="col-lg-4 d-none d-md-none d-lg-inline">
                        <img loading="lazy" src="{{ asset('assets/images/hero-home.svg') }}" alt="Hypenamic Event" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Upcoming Event</h3>

                    @if ($events)
                    <div class="row" id="main-content">
                    @foreach ($events as $index => $giat)
                        <div class="col-md-4 mb-3">
                            <div class="card shadow border-0">
                                @if (!empty($giat->event_banner))
                                <img loading="lazy" src="{{ asset($giat->event_banner) }}" alt="Image Heading" class="card-img-top" />
                                @else
                                <img loading="lazy" src="{{ asset('assets/images/empty-state.png') }}" alt="Hypenamic Event by Hypenamic Studio" class="card-img-top" />
                                @endif
                                <div class="card-alt">
                                    @if($giat->event_type == 'free')
                                    <span class="badge badge-warning text-white">Gratis</span>
                                    @else
                                        @if($giat->ticketsEvent()->select('price')->orderBy('price', 'ASC')->count() > 0)
                                            @php
                                            $ticket = $giat->ticketsEvent()->select('price')->orderBy('price', 'ASC')->first()->price;
                                            @endphp
                                            <span class="badge badge-warning text-white">Rp {{ number_format($ticket, 2, ',', '.') }}</span>
                                        @else
                                            <span class="badge badge-info text-white">Belum Ada Tiket</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @php
                                                $month = \Carbon\Carbon::parse($giat->event_start)->isoFormat('MMM');
                                                $date = \Carbon\Carbon::parse($giat->event_start)->isoFormat('D');

                                                $full = \Carbon\Carbon::parse($giat->event_start)->isoFormat('LLL');
                                            @endphp
                                            <div class="d-md-none mb-3">{{ $full }}</div>
                                            <div class="d-none d-md-flex flex-column d-sm-none align-items-center justify-content-center">
                                                <div class="h5">{{ $month }}</div>
                                                <div class="h4">{{ $date }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <h2 class="h5"><a class="text-dark" href="{{ route('jelajah.show', $giat->event_id) }}">{{ $giat->event_name }}</a></h2>
                                            <p class="mb-0">{{ $giat->event_desc_short }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    @else
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="alert alert-color alert-info text-center">
                                <p class="m-0">Daftar kategori dan event masih kosong!</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
<script src="{{ asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<script>
$('.owl-carousel').owlCarousel({
    loop: true,
    items: 1,
    autoplay: true,
    nav: false,
})
</script>
@endsection
