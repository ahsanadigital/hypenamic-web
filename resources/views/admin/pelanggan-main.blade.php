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
<header id="mainhead" class="">
    <div class="container-fluid py-5">
        <div class="d-flex justify-content-between">
            <div class="left">
                <h3>Semua Data Pelanggan</h3>
                <p class="m-0 text-muted">Menampilkan semua data pelanggan.</p>
            </div>
            <div class="right">
                <div class="dropdown no-caret d-md-none">
                    <a href="#" class="btn btn-lighter dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('admin.pelanggan-add') }}" class="dropdown-item"><i class="fas fa-plus fa-fw mr-2"></i>Tambah Data</a>
                    </div>
                </div>
                <a href="{{ route('admin.pelanggan-add') }}" class="btn btn-primary d-md-inline d-none d-sm-none"><i class="bx bx-plus mr-2"></i>Tambah Baru</a>
            </div>
        </div>
    </div>
</header>

<section id="main-content" class="mt-3">
    <div class="container">
        <div class="table-responsive card p-3">
            <table class="w-100 table m-0">
                <thead>
                    <tr>
                        <th data-orderable=false>#</th>
                        <th>Nama Lengkap</th>
                        <th>Instansi</th>
                        <th>Bergabung Sejak</th>
                        <th>Alamat Lengkap</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
@endsection

@section('footer')
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>

<script>
"use strict";

$('table').dataTable({
    ajax: {
        url: "{{ route('admin.pelanggan-data') }}",
        type: 'POST',
        data: {_token : '{{ csrf_token() }}'},
    },
    autoWidth: false,
    loading: true,

    columns: [
        {
            name: 'id_user',
            data: 'id_user',
            render: (a) => {
                let html = `<div class="btn-group btn-group-sm">
                    <a href="{{ url('/administrator/pelanggan') }}/${a}/view" class="btn btn-success"><i class="fas fa-eye"></i></a>
                    <a href="{{ url('/administrator/pelanggan') }}/${a}/edit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                    <button type="button" data-trigger="delete" data-target="{{ url('/administrator/pelanggan') }}/${a}/delete" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </div>`;
                return html;
            }
        },
        {
            name: 'fullname',
            data: 'fullname',
            render: (a) => {
                return `<p>${a}</p>`;
            }
        },
        {
            name: 'institution',
            data: 'institution',
            render: (a) => {
                return a;
            }
        },
        {
            name: 'created_at',
            data: 'created_at',
            render: (a, b, c, d) => {
                return moment(a).format('LLLL');
            }
        },
        {
            name: 'alamat',
            data: 'alamat',
            render: (a, b, c) => {
                return a;
            }
        },
    ]
});

// Delete
$(document).on('click', '[data-trigger="delete"]', function(e) {
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
            window.location.href = $(this).data('target');
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
</script>
@endsection
