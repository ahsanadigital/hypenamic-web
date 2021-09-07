@extends('templates.invoice')

@section('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
@endsection

@section('container')
<div class="container">
    <div class="row py-5 justify-content-center align-items-center min-vh-100">
        <div class="col-md-9">

            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark">
                    <div class="d-flex align-items-center flex-md-row flex-column text-white justify-content-between">
                        <div class="d-block">
                            <img src="{{ asset('assets/images/brands/hypenamic-event-white.png') }}" alt="Hypenamic Logo" height="50px" width="auto" class="mx-auto d-block" />
                        </div>

                        <div class="right text-center text-md-right">
                            <h3 class="h5 mb-0">#{{ $tiket->ticket_hash }}</h3>
                            <p class="m-0">Booking Pass</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center flex-md-row flex-column">
                        <img src="data:image/svg+xml;base64,{{ base64_encode($qr->generate($tiket->ticket_hash . '|' . "{$tiket->first_name} {$tiket->last_name}")) }}" style="height:150px" />

                        <div class="ml-4 mt-3 mt-md-0">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="section mb-3">
                                        <h3 class="h4">{{ $event->event_name }}</h3>
                                        <p class="m-0 text-muted">{{ $data_tiket->ticket_name }}</p>
                                    </div>
                                    <div class="section mb-3">
                                        <h3 class="h4">{{ Carbon\Carbon::parse($event->start_date)->isoFormat('D MMMM Y') }} &mdash; {{ Carbon\Carbon::parse($event->end_date)->isoFormat('D MMMM Y') }}</h3>
                                        <p class="m-0 text-muted">Tanggal Pelaksanaan</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="section mb-3">
                                        <h3 class="h4">Tempat Pelaksanaan</h3>
                                        @if($event->event_do == 'offline')
                                        @php
                                            $kelurahan = $wilayah->getKelurahan($event->kecamatan, $event->kelurahan);
                                            $kecamatan = $wilayah->getKecamatan($event->kabupaten, $event->kecamatan);
                                            $kabupaten = $wilayah->getKabupaten($event->provinsi, $event->kabupaten);
                                            $provinsi = $wilayah->getProvinsi($event->provinsi);
                                            @endphp
                                        <span class="badge badge-primary">Offline/Luring</span>
                                        <p class="m-0 text-muted">{{ $event->alamat ? $event->alamat . ', ' : '' }}{{ $kelurahan['nama'] }}, {{ $kecamatan['nama'] }}, {{ $kabupaten['nama'] }}, {{ $provinsi['nama'] }}</p>
                                        @else
                                        <div class="badge badge-success mb-3">Online/Daring</div>
                                        <a href="{{ $event->url }}" class="btn btn-primary btn-sm">Tautan Undangan Meeting<i class="fas fa-arrow-right fa-fw ml-2"></i></a>
                                        @endif
                                    </div>

                                    <h3>Pelaksanaan</h3>
                                    @if ($data_tiket->expiry_on == 'kegiatan')
                                        @php
                                        $today          = now()->timestamp;
                                        $limit_start    = Carbon\Carbon::parse($event->start_date)->subDays(1)->timestamp;
                                        $limit_end      = Carbon\Carbon::parse($event->start_date)->timestamp;
                                        @endphp

                                        @if (now()->timestamp)
                                        <span class="badge badge-primary">{{ Carbon\Carbon::parse("{$event->start_date} {$event->start_time}")->isoFormat('LLLL') }}</span>
                                        @elseif($today >= $limit_start && $today <= $limit_end)
                                        <span class="badge badge-warning">Kegiatan Akan Mulai Besok!</span>
                                        @else
                                        <span class="badge badge-warning">Telah Berakhir!</span>
                                        @endif
                                    @elseif($data_tiket->expiry_on == 'besok')
                                        @php
                                        $today = now()->timestamp;
                                        $limit_start = Carbon\Carbon::parse($data_tiket->created_at)->timestamp;
                                        $limit_end = Carbon\Carbon::parse($data_tiket->created_at)->addDays(1)->timestamp;
                                        @endphp

                                        @if ($today >= $limit_start || $today <= $limit_end)
                                        <span class="badge badge-warning">Besok!</span>
                                        @else
                                        <span class="badge badge-warning">Telah Berakhir!</span>
                                        @endif
                                    @elseif($data_tiket->expiry_on == 'hari_ini')
                                        @php
                                        $today = now()->timestamp;
                                        $limit_end = Carbon\Carbon::parse($data_tiket->created_at)->timestamp;
                                        @endphp

                                        @if ($today <= $limit_end)
                                        <span class="badge badge-warning">Hari Ini!</span>
                                        @else
                                        <span class="badge badge-warning">Telah Berakhir!</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
            </div>

        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
@endsection
