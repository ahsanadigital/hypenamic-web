@extends('templates.admin')

@section('header')
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/datetime/css/bootstrap-datetimepicker.min.css') }}" />

<style>
.card-img-top {
    height: 15rem;
    background: url("{{ $event->event_banner ? asset($event->event_banner) : asset('assets/images/icon-empty.png') }}") no-repeat center center;
    background-size: cover;
}

.img-profile {
    width: 275px;
    height: 275px;
    border-radius: 50%;
    margin-top: -9rem;
    border: 1px solid #e3e3e3;
    margin-bottom: 1rem;
    background-color: #fff;
}
</style>
@endsection

@section('container')
<div class="container-fluid mt-3">

    <div class="card">
        <div class="card-img-top"></div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">

                    <img src="{{ $event->thumbnail ? asset($event->thumbnail) : asset('assets/images/icon-empty.png') }}" class="img-profile d-block mx-auto" alt="{{ $event->event_name }}" />

                    <h3>{{ $event->event_name }}</h3>
                    <p class="text-muted">{{ $event->event_desc_short }}</p>

                    <ul class="list-unstyled m-0">
                        <li><i class="fas fa-fw fa-calendar mr-2"></i>{{ Carbon::parse("{$event->start_date} {$event->start_time}")->isoFormat('LL') }} - {{ Carbon::parse("{$event->end_date} {$event->end_time}")->isoFormat('LL') }}</li>
                        <li><i class="fas fa-fw fa-clock mr-2"></i>{{ Carbon::parse("{$event->start_date} {$event->start_time}")->isoFormat('HH.MM.ss') }} - {{ Carbon::parse("{$event->end_date} {$event->end_time}")->isoFormat('HH.MM.ss') }}</li>
                        @if($event->event_do == 'online')
                        <li><i class="fas fa-fw fa-map-marker mr-2"></i><span class="badge badge-success">Kegiatan Daring</span></li>
                        @else
                            @php
                            $kelurahan = $wilayah->getKelurahan($event->kecamatan, $event->kelurahan);
                            $kecamatan = $wilayah->getKecamatan($event->kabupaten, $event->kecamatan);
                            $kabupaten = $wilayah->getKabupaten($event->provinsi, $event->kabupaten);
                            $provinsi = $wilayah->getProvinsi($event->provinsi);
                            @endphp
                        <li><i class="fas fa-fw fa-map-marker mr-2"></i>{{ $event->alamat ? $event->alamat . ', ' : '' }}{{ $kelurahan['nama'] }}, {{ $kecamatan['nama'] }}, {{ $kabupaten['nama'] }}, {{ $provinsi['nama'] }}</li>
                        @endif

                        @if($event->status == 'open')
                        <li><i class="fas fa-fw fa-check-circle mr-2"></i><span class="badge-success badge">Masih Dibuka</span></li>
                        @else
                        <li><i class="fas fa-fw fa-check-circle mr-2"></i><span class="badge-danger badge">Sudah Ditutup</span></li>
                        @endif
                    </ul>
                </div>

                <div class="card-body">
                    <div class="btn-group w-100">
                        <a href="{{ route('admin.event-edit', $event->event_id) }}" class="btn btn-success"><i class="fas fa-fw fa-pencil-alt mr-2"></i>Edit</a>
                        <a href="{{ route('admin.event-delete', $event->event_id) }}" class="btn btn-danger btn-delete"><i class="fas fa-fw fa-trash mr-2"></i>Hapus</a>
                    </div>
                </div>
            </div>

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
        <div class="col-md-8">

            <div class="card-body card mb-3">
                <h3 class="h5">Deskirpsi Kegiatan</h3>
                <div>{!! $event->event_desc !!}</div>
            </div>

            <div class="card-body card mb-3">
                <h3 class="h5">Aturan Kegiatan</h3>
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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3 class="h5 m-0">Daftar Tiket</h3>
                        <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalAddTicket"><i class="fas fa-plus fa-fw"></i><span class="ml-2 d-none d-md-inline d-sm-none">Tambahkan Data</span></button>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                @if($event->ticketsEvent()->orderBy('price', 'ASC')->count())
                    @foreach ($event->ticketsEvent()->orderBy('price', 'ASC')->get() as $data)
                    <li class="list-group-item p-0">
                        <div class="d-flex">
                            <div class="mr-2 p-3 text-white rounded-left bg-primary flex-column align-items-center d-flex">
                                <i class="fas fa-ticket-alt fa-2x"></i>

                                <div class="nav align-items-center justify-content-center flex-column mt-4">
                                    <a href="javascript:void(editData('{{ $data->id_ticket }}'))" class="text-white nav-link"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="" class="text-white nav-link"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                            <div class="right w-100 p-3">
                                <div class="d-inline-block">
                                    <h3>{{ $data->ticket_name }}</h3>
                                    @if ($data->status == 'closed')
                                    <div>
                                        <span class="badge badge-danger">Ditutup</span>
                                    </div>
                                    @endif
                                </div>
                                <p class="text-muted">{!! $data->description_tiket !!}</p>

                                <div class="justify-content-between d-flex">
                                    <div class="stock">{{ $helper->thFormat($data->stok) }} tiket tersisa</div>
                                    <div class="price">{!! ($data->price > 0 ? $helper->thousandsCurrencyFormat($data->price) : 'Gratis') !!}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                @else
                    <div class="list-group-item text-center">
                        <h3 class="h4">Masih Kosong Nih</h3>
                        <p class="text-muted">Tambahkan satu tiket yuk untuk memulai acaranya</p>
                        <a href="" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Tambahkan Tiket</a>
                    </div>
                @endif
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modalAddTicket" tabindex="-1" aria-labelledby="modalAddTicketLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTicketLabel">Tambah Tiket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('admin.event-ticket-addProcess') }}" id="addTicket" method="POST">
                    @csrf

                    <input type="hidden" name="event_id" value="{{ $event->event_id }}" />

                    <div class="form-group">
                        <label for="ticket_name">Nama Tiket</label>
                        <input type="text" id="ticket_name" placeholder="Masukkan nama tiket" name="ticket_name" class="form-control" />
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="stok">Jumlah Tiket</label>
                                <input type="number" id="stok" placeholder="Masukkan jumlah tiket" name="stok" class="form-control" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Harga Tiket</label>
                                <input type="number" id="price"{{ $event->event_type == 'free' ? ' disabled value=0' : '' }} placeholder="Masukkan jumlah tiket" name="price" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="end_date">Tersedia Sampai</label>
                                <input type="datetime" id="end_date" placeholder="Masukkan tanggal" name="end_date" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="expiry_on">Berlaku Sampai</label>
                                <select name="expiry_on" id="expiry_on" class="form-control">
                                    <option value="besok">Sehari setelah pembelian</option>
                                    <option value="hari_ini">Hari ini setelah pembelian</option>
                                    <option value="kegiatan">Waktu kegiatan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>Status</label>
                        <div class="input-card-container">
                            <label for="open" class="input-custom-card mb-3 mb-md-0">
                                <input type="radio" class="input-custom" name="status" checked value="open" id="open" />
                                <div class="input-wrap">
                                    <div class="input-header">
                                        <div class="indicator"></div>
                                        <span>Dibuka</span>
                                    </div>
                                </div>
                            </label>
                            <label for="closed" class="input-custom-card">
                                <input type="radio" class="input-custom" name="status" value="closed" id="closed" />
                                <div class="input-wrap">
                                    <div class="input-header">
                                        <div class="indicator"></div>
                                        <span>Ditutup</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description_tiket">Deskripsi Tiket</label>
                        <textarea name="description_tiket" class="summernote form-control" id="description_tiket" cols="30" rows="5"></textarea>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn-submit-ticket btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditTicket" tabindex="-1" aria-labelledby="modalEditTicketLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTicketLabel">Ubah Detail Tiket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('admin.event-ticket-editProcess') }}" id="editTicket" method="POST">
                    @csrf

                    <input type="hidden" name="event_id" value="{{ $event->event_id }}" />
                    <input type="hidden" name="id_ticket" />

                    <div class="form-group">
                        <label for="ticket_name">Nama Tiket</label>
                        <input type="text" id="ticket_name" placeholder="Masukkan nama tiket" name="ticket_name" class="form-control" />
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="stok">Jumlah Tiket</label>
                                <input type="number" id="stok" placeholder="Masukkan jumlah tiket" name="stok" class="form-control" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Harga Tiket</label>
                                <input type="number" id="price"{{ $event->event_type == 'free' ? ' disabled value=0' : '' }} placeholder="Masukkan jumlah tiket" name="price" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="end_date">Tersedia Sampai</label>
                                <input type="datetime" id="end_date2" placeholder="Masukkan tanggal" name="end_date" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="expiry_on">Berlaku Sampai</label>
                                <select name="expiry_on" id="expiry_on" class="form-control"></select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>Status</label>
                        <div class="input-card-container">
                            <label for="open2" class="input-custom-card mb-3 mb-md-0">
                                <input type="radio" class="input-custom" name="status" checked value="open" id="open2" />
                                <div class="input-wrap">
                                    <div class="input-header">
                                        <div class="indicator"></div>
                                        <span>Dibuka</span>
                                    </div>
                                </div>
                            </label>
                            <label for="closed2" class="input-custom-card">
                                <input type="radio" class="input-custom" name="status" value="closed" id="closed2" />
                                <div class="input-wrap">
                                    <div class="input-header">
                                        <div class="indicator"></div>
                                        <span>Ditutup</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description_tiket">Deskripsi Tiket</label>
                        <textarea name="description_tiket" class="summernote form-control" id="description_tiket" cols="30" rows="5"></textarea>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn-edit-ticket btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('vendor/summernote/lang/summernote-id-ID.min.js') }}"></script>

<script src="{{ asset('vendor/datetime/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
// Ticket Edit
function editData(e) {
    $.getJSON('{{ route("admin.event-ticket-detail") }}', { id: e })
    .then(res => {
        let result = res;
        $('#modalEditTicket [name="id_ticket"]').val(result.id_ticket);
        $('#modalEditTicket [name="stok"]').val(result.stok);
        $('#modalEditTicket [name="ticket_name"]').val(result.ticket_name);
        $('#modalEditTicket [name="end_date"]').val(result.end_date);
        $('#modalEditTicket #description_tiket').summernote('code', result.description_tiket);

        let dataHtml = `<option${result.expiry_on == 'besok' ? ' selected' : ''} value="besok">Sehari setelah pembelian</option>
        <option${result.expiry_on == 'hari_ini' ? ' selected' : ''} value="hari_ini">Hari ini setelah pembelian</option>
        <option${result.expiry_on == 'kegiatan' ? ' selected' : ''} value="kegiatan">Waktu kegiatan</option>`;
        $('#modalEditTicket [name="expiry_on"]').html(dataHtml);

        if(result.status == 'open') {
            $('#modalEditTicket #open2').prop({'checked': true});
            $('#modalEditTicket #closed2').prop({'checked': false});
        } else {
            $('#modalEditTicket #open2').prop({'checked': false});
            $('#modalEditTicket #closed2').prop({'checked': true});
        }

        $('#modalEditTicket').modal('show');
    });
}
// Submit Event
$('.btn-edit-ticket').click(function() {
    let form = $('#editTicket');
    console.log(form, form.serialize());

    let data = form.serialize();
    let urls = form.attr('action');
    let type = form.attr('method');

    $.ajax({
        url: urls,
        data: data,
        type: type,

        beforeSend() {
            Swal.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                title: 'Sedang Memproses!',
                text: 'Tunggu sebentar ya? Sistem sedang memproses permintaan anda!',
                didOpen() {
                    Swal.showLoading()
                }
            });
        },
        success(result) {
            let res = result;

            successAlert.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                title: 'Berhasil!',
                text: 'Berhasil mengubah data, sistem akan memuat ulang halaman ini.',
                didOpen() {
                    Swal.showLoading()
                }
            });

            setTimeout(() => {
                $('#addTicket').modal('hide');
                window.location.reload();
            }, 2500);
        },
        error(exceptions) {
            let error = exceptions.responseJSON;
            let html = '<div class="list-group">';

            $.each(error.data, (a, b) => {
                html += `<div class="list-group-item">${b}</div>`;
            });
            html += `</div>`;

            warnAlert.fire({
                title: 'Ups, Maaf!',
                html: `<p>${error.message}</p>${html}`,
            });
        },
    });
});

// Submit Event
$('.btn-submit-ticket').click(function() {
    let form = $('#addTicket');
    let data = form.serialize();
    let urls = form.attr('action');
    let type = form.attr('method');

    $.ajax({
        url: urls,
        data: data,
        type: type,

        beforeSend() {
            Swal.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                title: 'Sedang Memproses!',
                text: 'Tunggu sebentar ya? Sistem sedang memproses permintaan anda!',
                didOpen() {
                    Swal.showLoading()
                }
            });
        },
        success(result) {
            let res = result;

            successAlert.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                title: 'Berhasil!',
                text: 'Berhasil mengubah data, sistem akan memuat ulang halaman ini.',
                didOpen() {
                    Swal.showLoading()
                }
            });

            setTimeout(() => {
                $('#addTicket').modal('hide');
                window.location.reload();
            }, 2500);
        },
        error(exceptions) {
            let error = exceptions.responseJSON;
            let html = '<div class="list-group">';

            $.each(error.data, (a, b) => {
                html += `<div class="list-group-item">${b}</div>`;
            });
            html += `</div>`;

            warnAlert.fire({
                title: 'Ups, Maaf!',
                html: `<p>${error.message}</p>${html}`,
            });
        },
    });
});

// Datepicker
$('#end_date, #end_date2').datetimepicker({
    locale: moment.locale('id'),
    format: 'YYYY-MM-DD HH:mm:ss',
    showClose: true,
    showClear: true,
    inline: true,
    minDate: '{{ Carbon\Carbon::parse($event->start_date . ' ' . $event->start_time) }}',
    icons: {
        time: 'fas fa-clock',
        date: 'fas fa-calendar',
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-crosshairs',
        clear: 'fas fa-trash',
        close: 'fas fa-times',
    },
    tooltips: {
        today: 'Ke Hari Ini',
        clear: 'Hapus Seleksi',
        close: 'Tutup',
        selectMonth: 'Pilih Bulan',
        prevMonth: 'Bulan Sebelumnya',
        nextMonth: 'Bulan Selanjutnya',
        selectYear: 'Pilih Tahun',
        prevYear: 'Tahun Sebelumnya',
        nextYear: 'Tahun Selanjutnya',
        selectDecade: 'Dekade Pilih',
        prevDecade: 'Dekade Sebelumnya',
        nextDecade: 'Dekade Selanjutnya',
        prevCentury: 'Abad Sebelumnya',
        nextCentury: 'Abad Selanjutnya'
    }
});

// Delete Action
$('.btn-delete').click(function(e) {
    e.preventDefault();

    warnAlert.fire({
        title: 'Yakin Mau Menghapus?',
        text:  'Data yang sudah dihapus akan hilang selamanya dan tidak dapat dikembalikan ya?',
        showConfirmButton: true,
        showCancelButton: true,

        confirmButtonText: 'Hapus Saja',
        cancelButtonText: 'Batalin',
    }).then(result => {
        if(result.isConfirmed) {
            window.location.href = $(this).attr('href');
            Swal.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                title: 'Sedang Memproses!',
                text: 'Tunggu sebentar ya? Sistem sedang memproses permintaan anda!',
                didOpen() {
                    Swal.showLoading()
                }
            });
        }
    });
});

// SummerNote
$('.summernote').summernote({
    lang: 'id-ID',
    toolbar: [
        // [groupName, [list of button]]
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['para', ['ul', 'ol']]
    ],
    height: '150px',
});
</script>
@endsection
