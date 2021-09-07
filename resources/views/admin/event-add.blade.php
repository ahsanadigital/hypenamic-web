@extends('templates.admin')

@section('header')
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/datetime/css/bootstrap-datetimepicker.min.css') }}" />

<style>
    .form-button:hover {
        cursor: pointer;
    }
</style>
@endsection

@section('container')
<header class="py-5">
    <div class="container-fluid">
        <div class="d-md-flex justify-content-between">
            <div class="left">
                <h3>Tambah Data</h3>
                <p class="text-muted m-0">Menambahkan data kegiatan.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-sm-0 px-md-3 bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ route('admin.main') }}" class="breadcrumb-link">Beranda Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.event-main') }}" class="breadcrumb-link">Kegiatan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
                </ol>
            </nav>
        </div>
    </div>
</header>

<section id="main-content">
    <div class="container">
        <div class="card card-body">
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0)">Data Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="javascript:void(0)"><i class="fas fa-ticket-alt fa-fw mr-2"></i>Data Tiket</a>
                </li>
            </ul>

            <form action="{{ route('admin.event-addProcess') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8 mb-3 mb-md-0">

                        <div class="form-group floating-alt">
                            <input type="text" class="form-control floating" name="event_name" id="event_name"
                                placeholder="Masukkan nama kegiatan" required />
                            <label for="event_name">Nama Kegiatan</label>
                        </div>

                        <div class="form-group" onclick="openModal('#userModal')">
                            <input type="hidden" name="id_user" />
                            <label for="id_user">Nama Penyelenggara</label>
                            <input type="text" class="form-control form-button floating" readonly id="id_user"
                                placeholder="Masukkan penyelenggara" required />
                        </div>

                        <div class="form-group" onclick="openModal('#categoryModal')">
                            <input type="hidden" name="category" />
                            <label for="category">Kategori Kegiatan</label>
                            <input type="text" class="form-control form-button floating" readonly id="category"
                                placeholder="Masukkan kategori" required />
                        </div>

                        <div class="form-group">
                            <label for="event_desc">Deskripsi Kegiatan</label>
                            <textarea id="event_desc" placeholder="Masukkan deskripsi kegiatanmu"
                                class="form-control summernote" rows="3" name="event_desc"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="event_desc_short">Deskripsi Event</label>
                            <textarea name="event_desc_short" id="event_desc_short" cols="30" rows="5"
                                class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="heading d-flex">
                                <div class="left">
                                    <h4>Syarat dan Aturan Kegiatan</h4>
                                    <p class="text-muted">Tambahkan syarat dan ketentuan untuk memberikan penjelasan
                                        terkait aturan kegiatanmu</p>
                                </div>
                                <div class="right"><button class="btn btn-light" type="button" data-toggle="modal"
                                        data-target="#tosModal"><i class="fas fa-plus"></i></button></div>
                            </div>

                            <div class="result-tos accordion" id="tos-collapse">
                                <div class="alert alert-fill alert-icon alert-info text-white m-0">
                                    <div class="icon-wrapper">
                                        <i class="bx bx-info-circle"></i>
                                    </div>
                                    <h3 class="h5">Masih belum ada data!</h3>
                                    <p class="m-0">Tambahkan satu yuk di tombol tambah diatas kanan!</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">

                        <div class="form-group mb-4">
                            <label>Kegiatan Dilaksanakan Di?</label>
                            <div class="input-card-container">
                                <label for="event_do" class="input-custom-card mb-3 mb-md-0">
                                    <input type="radio" class="input-custom" name="event_do" checked value="offline" id="event_do" />
                                    <div class="input-wrap">
                                        <div class="input-header">
                                            <div class="indicator"></div>
                                            <span>Offline</span>
                                        </div>
                                    </div>
                                </label>
                                <label for="event_do2" class="input-custom-card">
                                    <input type="radio" class="input-custom" name="event_do" value="online" id="event_do2" />
                                    <div class="input-wrap">
                                        <div class="input-header">
                                            <div class="indicator"></div>
                                            <span>Online</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="collapse" id="online">
                            <div class="form-group floating">
                                <input type="text" class="form-control" id="url" name="url" placeholder="Masukkan URL Zoom atau kegiatan" />
                                <label for="url">Tautan Kegiatan</label>
                            </div>
                        </div>
                        <div class="collapse show" id="offline">
                            <div class="form-group floating">
                                <select name="provinsi" class="form-control" id="provinsi">
                                    <option disabled selected>Pilih Salah Satu</option>
                                </select>
                                <label for="provinsi">Pilih Provinsi</label>
                            </div>
                            <div class="form-group floating">
                                <select name="kabupaten" class="form-control" id="kabupaten">
                                    <option disabled selected>Pilih Provinsi Dulu</option>
                                </select>
                                <label for="kabupaten">Pilih Kabupaten</label>
                            </div>
                            <div class="form-group floating">
                                <select name="kecamatan" class="form-control" id="kecamatan">
                                    <option disabled selected>Pilih Provinsi Dulu</option>
                                </select>
                                <label for="kecamatan">Pilih Kabupaten</label>
                            </div>
                            <div class="form-group floating">
                                <select name="kelurahan" class="form-control" id="kelurahan">
                                    <option disabled selected>Pilih Provinsi Dulu</option>
                                </select>
                                <label for="kelurahan">Pilih Kabupaten</label>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Pilih Kabupaten</label>
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat kegiatan" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="banner">Unggah Berkas Banner</label>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo" />
                                <label class="custom-file-label" for="logo">Pilih berkas</label>
                            </div>
                            <div class="form-text text-muted">Anda dapat mengunggah berkas dengan ukuran maksimal 5MB dan tipe berkas JPG/PNG.</div>
                        </div>

                        <div class="form-group">
                            <label for="logo">Unggah Berkas Logo</label>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="banner" name="banner" />
                                <label class="custom-file-label" for="banner">Pilih berkas</label>
                            </div>
                            <div class="form-text text-muted">Anda dapat mengunggah berkas dengan ukuran maksimal 3MB dan tipe berkas JPG/PNG.</div>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Tanggal Kegiatan Dimulai</label>
                            <input type="text" class="form-control" name="start_date" value required id="start_date" />
                        </div>

                        <div class="form-group">
                            <label for="end_date">Tanggal Kegiatan Berakhir</label>
                            <input type="text" class="form-control" name="end_date" value required id="end_date" />
                        </div>

                        <div class="form-group mb-4">
                            <label>Status Kegiatan?</label>
                            <div class="input-card-container">
                                <label for="open" class="input-custom-card">
                                    <input type="radio" class="input-custom" name="status" value="open" id="open" />
                                    <div class="input-wrap">
                                        <div class="input-header">
                                            <div class="indicator"></div>
                                            <span>Masih Terbuka</span>
                                        </div>
                                    </div>
                                </label>
                                <label for="closed" class="input-custom-card">
                                    <input type="radio" class="input-custom" name="status" value="closed" id="closed" />
                                    <div class="input-wrap">
                                        <div class="input-header">
                                            <div class="indicator"></div>
                                            <span>Sudah Ditutup</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label>Jenis Kegiatan</label>
                            <div class="input-card-container">
                                <label for="free" class="input-custom-card">
                                    <input type="radio" class="input-custom" name="event_type" value="free" id="free" />
                                    <div class="input-wrap">
                                        <div class="input-header">
                                            <div class="indicator"></div>
                                            <span>Gratis</span>
                                        </div>
                                    </div>
                                </label>
                                <label for="bayar" class="input-custom-card">
                                    <input type="radio" class="input-custom" name="event_type" value="bayar" id="bayar" />
                                    <div class="input-wrap">
                                        <div class="input-header">
                                            <div class="indicator"></div>
                                            <span>Berbayar</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-save mr-2"></i>Simpan</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
</section>

<!-- Modal Search User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Cari Nama Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <nav>
                    <div class="nav nav-inline nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" href="javascript:void(0)">Cari Pelanggan</a>
                        <a class="nav-link" href="javascript:void(0)">Tambah Baru</a>
                    </div>
                </nav>

                <form action="{{ route('admin.event-suser') }}" id="search-user" class="mt-4" method="POST">
                    @csrf
                    <div class="form-group floating">
                        <input type="text" required class="form-control floating" name="username" id="username" value=""
                            placeholder="Masukkan nama pengguna lalu tekan enter" />
                        <label for="username">Nama Pengguna</label>
                    </div>

                    <div class="result"></div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal Category -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Cari Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <nav>
                    <div class="nav nav-inline nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                            aria-controls="nav-home" aria-selected="true">Cari Kategori</a>
                        <a class="nav-link" id="nav-addcategory-tab" data-toggle="tab" href="#nav-addcategory"
                            role="tab" aria-controls="nav-addcategory" aria-selected="false">Tambah Kategori Baru</a>
                    </div>
                </nav>
                <div class="tab-content mt-4" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                        <form action="{{ route('admin.event-scat') }}" id="category-search" method="POST">
                            @csrf
                            <div class="form-group floating">
                                <input type="text" required class="form-control floating" name="category" id="category"
                                    placeholder="Masukkan nama pengguna lalu tekan enter" />
                                <label for="category">Nama Kategori</label>
                            </div>

                            <div class="result"></div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="nav-addcategory" role="tabpanel"
                        aria-labelledby="nav-addcategory-tab">

                        <form action="{{ route('admin.event-cat') }}" method="POST" id="add-category">
                            @csrf

                            <div class="form-group floating">
                                <input type="text" required class="form-control" name="cat_name" id="ad-cat"
                                    placeholder="Tambahkan nama Kategori" />
                                <label for="ad-cat">Tambahkan Kategori</label>
                            </div>

                            <button class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Tambahkan</button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tosModal" tabindex="-1" aria-labelledby="tosModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tosModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" id="add-tos">
                    <div class="form-group floating">
                        <input type="text" class="form-control" name="tos_title" placeholder="Masukkan Judul Aturan" id="tos-title" required />
                        <label for="tos-title">Judul Aturan</label>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi-tos">Deskripsi Aturan</label>
                        <textarea id="deskripsi-tos" cols="30" name="tos_desc" rows="5" class="summernote form-control" placeholder="Masukkan deskripsi aturan"></textarea>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" data-target="#add-tos">Simpan</button>
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

// Open modal
function openModal(el, e) {
    let elem = $(`${el}`);
    if (elem.length > 0) {
        elem.modal('show');
    } else {
        console.error('Target elemen tidak dapat ditemukan!');
    }
}

// User Search
$('#search-user').submit(function (e) {
    e.preventDefault();
    $.ajax({
        data: $(this).serialize(),
        url: $(this).attr('action'),
        method: $(this).attr('method'),

        beforeSend() {},
        success(e) {
            let result = e.data;
            let html = '<div class="list-group">';
            if (result.length > 0) {
                for (let index = 0; index < result.length; index++) {
                    let res = result[index];
                    html += `<a href="javascript:selectData(['${res.id_user}', '${res.fullname}', '${e.csrf}'], ['#userModal', '#id_user', 'input[name=id_user]'])" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between">
                        <div class="left">
                            <h3 class="h5">${res.fullname}</h3>
                            <p class="m-0 text-muted">${res.institution}</p>
                        </div>
                        <div class="right">
                            <div class="badge badge-success">Aktif</div>
                            ${ res.type == 'admin' ? '<div class="badge badge-info text-white">Admin</div>' : false }
                        </div>
                    </div>
                </a>`;
                }
            } else {
                html += '<div class="list-group-item">Maaf, data tidak dapat ditemukan!</div>';
            }
            html += '</div>';

            $('#search-user .result').html(html);
        },
        error(e) {
            $('#search-user .result').html(`<div class="list-group-item">
            <div class="alert alert-fill alert-icon alert-danger text-white m-0">
                <div class="icon-wrapper">
                    <i class="bx bx-error"></i>
                </div>
                <h3 class="h5">Kesalahan!</h3>
                <p class="m-0">Peladen sedang sibuk!</p>
            </div>
        </div>`);
        },
    });
});

// Category Search
$('#add-category').submit(function (e) {
    e.preventDefault();

    if ($('#add-category [name="cat_name"]').val() !== '') {
        $.ajax({
            data: $(this).serialize(),
            url: $(this).attr('action'),
            method: $(this).attr('method'),

            success(e) {
                let data = e.data;
                $('#add-category input[name="cat_name"]').val('');
                $('#add-category input[name="_token"]').val(e.token);

                $('[name="category"]').val(data.slug);
                $('#category').val(data.cat_name);
                $('#categoryModal').modal('hide');
            }
        });
    }
});
$('#category-search').submit(function (e) {
    e.preventDefault();
    $.ajax({
        data: $(this).serialize(),
        url: $(this).attr('action'),
        method: $(this).attr('method'),

        beforeSend() {},
        success(e) {
            let result = e.data;
            let html = '<div class="list-group">';
            if (result.length > 0) {
                for (let index = 0; index < result.length; index++) {
                    let res = result[index];
                    html += `<a href="javascript:selectData(['${res.slug}', '${res.cat_name}', '${e.csrf}'], ['#categoryModal', '#category', 'input[name=category]'])" class="list-group-item list-group-item-action">
                    <span>${res.cat_name}</span>
                </a>`;
                }
            } else {
                html += '<div class="list-group-item">Maaf, data tidak dapat ditemukan!</div>';
            }
            html += '</div>';

            $('#category-search .result').html(html);
        },
        error(e) {
            $('#category-search .result').html(`<div class="list-group-item">
            <div class="alert alert-fill alert-icon alert-danger text-white m-0">
                <div class="icon-wrapper">
                    <i class="bx bx-error"></i>
                </div>
                <h3 class="h5">Kesalahan!</h3>
                <p class="m-0">Peladen sedang sibuk!</p>
            </div>
        </div>`);
        },
    });
});

// Select Data
function selectData(a, b) {
    let el = b;
    let data = a;

    $(`${b[0]}`).modal('hide');
    $(`${b[0]} input`).val('');
    $(`${b[0]} .result`).html('');
    $(`${b[0]} [name="_token"]`).val(a[2]);

    $(`${b[2]}`).val(a[0]);
    $(`${b[1]}`).prop({
        'valid': true
    }).val(a[1]);
};

// Time Picker
$('#start_date, #end_date').datetimepicker({
    locale: moment.locale('id'),
    format: 'YYYY-MM-DD HH:mm:ss',
    showClose: true,
    showClear: true,
    minDate: 'now',
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

// TOS
$('button[data-target="#add-tos"]').click(function() {
    let input1 = $('input[name="tos_title"]');
    let input2 = $('[name="tos_desc"]');
    let input_title = input1.val();
    let input_desc = input2.val();
    let target = $('.result-tos');
    let rand = (Math.random() + 1).toString(36).substring(7);

    if(input_title == '' || input_desc == '') {
        warnAlert.fire({
            title: 'Nampaknya Masih Ada Yang Kosong?',
            text: 'Yuk cek kembali masukan yang masih kosong?!',
            icon: 'warning',
        });
    } else {
        let html = `<div class="card" id="${rand}">

            <input value="${input_title}" type="hidden" name="tos[${rand}][title]" />
            <input value="${input_desc}" type="hidden" name="tos[${rand}][desc]" />

            <div class="card-header" id="heading-${rand}">
                <div class="d-flex justify-content-between">
                    <div class="left" style="width:85%">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-${rand}" aria-expanded="true" aria-controls="collapse-${rand}">${input_title}</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btn btn-danger btn-delete-tos" data-target="#${rand}"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>

            <div id="collapse-${rand}" class="collapse" aria-labelledby="heading-${rand}" data-parent="#tos-collapse">
                <div class="card-body">
                    ${input_desc}
                </div>
            </div>
        </div>`;
        if(target.find('.alert').length) {
            target.find('.alert').remove();
            target.append(html);
        } else {
            target.append(html);
        }
        $('#tosModal').modal('hide');
        input1.val('');
        input2.summernote('code', '');;
    }
});
$(document).on('click', '.btn-delete-tos', function(e) {
    let those  = this;
    let elem   = $(those);
    let target = elem.data('target');
    $(`${target}`).remove();

    if($('.result-tos').find('.card').length == 0) {
        let html = `<div class="alert alert-fill alert-icon alert-info text-white m-0">
            <div class="icon-wrapper">
                <i class="bx bx-info-circle"></i>
            </div>
            <h3 class="h5">Masih belum ada data!</h3>
            <p class="m-0">Tambahkan satu yuk di tombol tambah diatas kanan!</p>
        </div>`;
        $('.result-tos').append(html);
    }
});

// Event Do Change
$('input[name="event_do"]').change(function(e) {
    let those = $(e.target);
    let targets = those.attr('id');

    if(targets == 'event_do') {
        $('.collapse#online').collapse('hide');
        $('.collapse#offline').collapse('show');
    } else {
        $('.collapse#online').collapse('show');
        $('.collapse#offline').collapse('hide');
    }
});

// Wilayah Indonesia
axios.get('{{ route("wilayah.provinsi") }}').then((e) => {
    let data = e.data.items;
    $.each(data, (a, b) => {
        $('select#provinsi').append(`<option value="${b.id}">${b.nama}</option>`);
    });
});
$('select#provinsi').change(function() {
    let val = $(this).val();
    axios.get(`{{ url("api/wilayah") }}/${val}/kabupaten`).then((e) => {
        let data = e.data.items;
        $('select#kabupaten').html('<option disabled selected>Pilih Salah Satu</option>');
        $.each(data, (a, b) => {
            $('select#kabupaten').append(`<option value="${b.id}">${b.nama}</option>`);
        });
        $('select#kecamatan').html('<option disabled selected>Pilih Kabupaten Dulu</option>');
        $('select#kelurahan').html('<option disabled selected>Pilih Kecamatan Dulu</option>');
    });
});
$('select#kabupaten').change(function() {
    let val = $(this).val();
    axios.get(`{{ url("api/wilayah") }}/${val}/kecamatan`).then((e) => {
        let data = e.data.items;
        $('select#kecamatan').html('<option disabled selected>Pilih Salah Satu</option>');
        $.each(data, (a, b) => {
            $('select#kecamatan').append(`<option value="${b.id}">${b.nama}</option>`);
        });
        $('select#kelurahan').html('<option disabled selected>Pilih Kecamatan Dulu</option>');
    });
});
$('select#kecamatan').change(function() {
    let val = $(this).val();
    axios.get(`{{ url("api/wilayah") }}/${val}/kelurahan`).then((e) => {
        let data = e.data.items;
        $('select#kelurahan').html('<option disabled selected>Pilih Salah Satu</option>');
        $.each(data, (a, b) => {
            $('select#kelurahan').append(`<option value="${b.id}">${b.nama}</option>`);
        });
    });
});

// Submit
$('.card>form').submit(function(e) {
    e.preventDefault();

    let form = $(this);
    let data = form.serialize();
    let url  = form.attr('action');
    let type = form.attr('method');

    $.ajax({
        url: url,
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
            console.log(result);
            let res = result;

            successAlert.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                title: 'Berhasil!',
                text: 'Berhasil menambahkan data, sistem akan mengarahkan anda ke halaman detail eevnt ini',
                didOpen() {
                    Swal.showLoading()
                }
            });

            if(result.redirect) {
                setTimeout(() => {
                    window.location.href = res.redirect;
                }, 5000);
            }
        },
        error(exceptions) {
            console.log(exceptions);
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
</script>
@endsection
