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
                <h3>Semua Data Event</h3>
                <p class="m-0 text-muted">Menampilkan semua data event.</p>
            </div>
            <div class="right">
                <div class="dropdown no-caret d-md-none">
                    <a href="#" class="btn btn-lighter dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('admin.event-add') }}" class="dropdown-item"><i class="fas fa-plus fa-fw mr-2"></i>Tambah Data</a>
                    </div>
                </div>
                <a href="{{ route('admin.event-add') }}" class="btn btn-primary d-md-inline d-none d-sm-none"><i class="bx bx-plus mr-2"></i>Tambah Baru</a>
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
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Disorot?</th>
                        <th>Status</th>
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
        url: "{{ route('admin.event-data') }}",
        type: 'POST',
        data: {_token : '{{ csrf_token() }}'},
    },
    autoWidth: false,
    loading: true,

    columns: [
        {
            name: 'event_id',
            data: 'event_id',
            render: (a, b, c, d) => {
                let html = `<div class="btn-group btn-group-sm">
                    <a href="{{ url('/administrator/event') }}/${a}/view" class="btn btn-success"><i class="fas fa-eye"></i></a>
                    <a href="{{ url('/administrator/event') }}/${a}/edit" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                    <button type="button" data-trigger="delete" data-target="{{ url('/administrator/event') }}/${a}/delete" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </div>`;
                return html;
            }
        },
        {
            name: 'event_id',
            data: 'event_id',
            width: "65%",
            render: (a, b, c, d) => {
                return `<p>${c.event_name}</p>`;
            }
        },
        {
            name: 'event_id',
            data: 'event_id',
            render: (a, b, c, d) => {
                let date   = `${c.start_date} ${c.start_time}`;
                let format = moment(date).format('LLL');
                return format;
            }
        },
        {
            name: 'event_id',
            data: 'event_id',
            render: (a, b, c, d) => {
                if(c.event_do == 'offline') {
                    return '<span class="badge badge-info text-white"><i class="bx bx-map-pin"></i> Kegiatan Offline</span>';
                } else {
                    return '<span class="badge badge-success text-white"><i class="bx bx-circle"></i> Kegiatan Online</span>';
                }
            }
        },
        {
            name: 'event_id',
            data: 'event_id',
            render: (a, b, c) => {
                return `<a href="{{ url('event/o/') }}/${c.user_id}">${c.user}</a>`;
            }
        },
        {
            name: 'event_id',
            data: 'event_id',
            render: (a, b, c, d) => {
                if(c.highlight == 1)
                {
                    return '<i class="fas fa-check text-success"></i>';
                } else {
                    return '<i class="fas fa-times text-danger"></i>';
                }
            }
        },
        {
            name: 'event_id',
            data: 'event_id',
            render: (a, b, c, d) => {
                if(c.status == 'open')
                {
                    return '<span class="badge badge-success text-white">Masih Dibuka</span>';
                } else {
                    return '<span class="badge badge-danger text-white">Ditutup</span>';
                }
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
