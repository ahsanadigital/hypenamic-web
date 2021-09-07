@extends('templates.admin')

@section('header')
<link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}" />

<style>
th, td.no-wrap {
    white-space: nowrap;
}
[data-orderable=false] {
    background: none;
}
</style>
@endsection

@section('container')
<header class="py-5">
    <div class="container-fluid">
        <div class="d-md-flex justify-content-between">
            <div class="left">
                <h3>Data Kategori Event</h3>
                <p class="text-muted m-0"></p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-sm-0 px-md-3 bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ route('admin.main') }}" class="breadcrumb-link">Beranda Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.event-main') }}" class="breadcrumb-link">Kegiatan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kategori Kegiatan</li>
                </ol>
            </nav>
        </div>
    </div>
</header>

<section class="container py-3">
    <div class="container-fluid">
        <div class="card card-body">

            <div class="mb-3">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-plus mr-2"></i>Tambah Data
                </button>
            </div>

            <table class="table-striped border-0 table-borderless m-0 table w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('admin.category-edit') }}" id="edit">
                    @csrf

                    <input type="hidden" name="slug" id="slug" />

                    <div class="form-group floating">
                        <input id="cat_name" required name="cat_name" type="text" class="form-control" />
                        <label for="cat_name">Nama Kategori</label>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                <button type="button" onclick="saveEdit()" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('admin.category-add') }}" id="add">
                    @csrf

                    <div class="form-group floating">
                        <input id="cat_name" required name="cat_name" type="text" class="form-control" />
                        <label for="cat_name">Nama Kategori</label>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                <button type="button" onclick="saveAdd()" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
<script>
var table = $('table').dataTable({
    ajax: {
        url: "{{ route('admin.category-data') }}",
        type: 'POST',
        data: {_token : '{{ csrf_token() }}'},
    },
    autoWidth: false,
    loading: true,

    columns: [
        {
            data: 'slug',
            render: (a, b, c, d) => {
                let html = `<div class="btn-group btn-group-sm">
                    <button onclick="editClicked('${c.cat_name}', '${c.slug}')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal"><i class="fas fa-pencil-alt"></i></button>
                    <a href="{{ url('api/administrator/category') }}/${c.slug}/delete" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                </div>`;
                return html;
            }
        },
        {
            data: 'cat_name',
            render: (a, b, c, d) => {
                return a;
            }
        },
        {
            data: 'slug',
            render: (a, b, c, d) => {
                return a;
            }
        },
    ],
});

$('form#edit, form#add').submit((e) => {
    e.preventDefault();
});
function saveEdit() {
    let form = $('form#edit');
    let data = form.serialize();
    let url  = form.attr('action');
    let type = form.attr('method');

    console.log(form, data, url, type)

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
            let res = result;

            successAlert.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                title: 'Berhasil!',
                text: 'Berhasil mengubah data, sistem akan memuat ulang datatabel ini.',
                didOpen() {
                    Swal.showLoading()
                }
            });

            setTimeout(() => {
                $('#editModal').modal('hide');
                table.api().ajax.reload();
                Swal.close();
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
}
function saveAdd() {
    let form = $('form#add');
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
            let res = result;

            successAlert.fire({
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                title: 'Berhasil!',
                text: 'Berhasil mengubah data, sistem akan memuat ulang datatabel ini.',
                didOpen() {
                    Swal.showLoading()
                }
            });

            setTimeout(() => {
                $('#addModal').modal('hide');
                table.api().ajax.reload();
                Swal.close();
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
}
function editClicked(e, f) {
    $('form#edit #cat_name').val(e);
    $('form#edit #slug').val(f);
}
</script>
@endsection
