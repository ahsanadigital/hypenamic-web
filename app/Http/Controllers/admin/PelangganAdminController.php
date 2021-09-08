<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PelangganAdminController extends Controller
{
    function main()
    {
        $data['title'] = 'Data Pelanggan &mdash; ' . config('app.name');
        return view('admin.pelanggan-main', $data);
    }
    function datatable(Request $request)
    {
        return DataTables::of(User::where('type', '!=', 'admin')->get())
        ->addColumn('alamat', function($user) {
            $wilayah   = new Wilayah();

            $alamat    = ($user->alamat ? $user->alamat . ', ' : '');
            $kelurahan = $wilayah->getKelurahan($user->kecamatan, $user->kelurahan)['nama'];
            $kecamatan = $wilayah->getKecamatan($user->kabupaten, $user->kecamatan)['nama'];
            $kabupaten = $wilayah->getKabupaten($user->provinsi, $user->kabupaten)['nama'];
            $provinsi  = $wilayah->getProvinsi($user->provinsi)['nama'];

            return $alamat . $kelurahan . ', ' . $kecamatan . ', ' . $kabupaten . ', ' . $provinsi;
        })->toJSON();
    }

    function add()
    {
        $data['title'] = 'Tambah Pelanggan &mdash; ' . config('app.name');
        return view('admin.pelanggan-add', $data);
    }
    function addProcess(Request $request)
    {}
}
