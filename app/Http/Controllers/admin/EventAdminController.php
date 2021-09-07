<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Event;
use App\Models\Helper;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EventAdminController extends Controller
{
    /**
     * Data Index to show any data
     */
    function main()
    {
        $data['title'] = 'Data Event &mdash; ' . config('app.name');
        return view('admin.event-main', $data);
    }
    function datatable()
    {
        $data = Event::all();
        return DataTables::collection($data)
        ->removeColumn('id_user')
        ->addColumn('user', function(Event $evt) {
            return $evt->getUsers()->first()->fullname;
        })
        ->addColumn('user_id', function(Event $evt) {
            return $evt->getUsers()->first()->id_user;
        })->toJson();
    }
    function delete(Event $event, $id)
    {
        if($event->where('event_id', $id)->count() > 0)
        {
            $event->where('event_id', $id)->first()->ticketsEvent()->delete();
            $event->where('event_id', $id)->delete();

            return redirect()->route('admin.event-main')->with('success', 'Berhasil menghapus data event dengan ID "' . $id . '"!');
        } else {
            return redirect()->route('admin.event-main')->with('error', 'Gagal menghapus data event dengan ID "' . $id . '", karena tidak ada dalam database!');
        }
    }

    /**
     * View Data
     */
    function view(Event $event, $id, Wilayah $wilayah, Helper $helper)
    {
        $datas = $event->where('event_id', $id);
        if($datas->count() > 0) {
            $event = $datas->first();
            $data['event'] = $event;
            $data['helper'] = $helper;
            $data['author'] = $data['event']->getUsers()->first();
            $data['wilayah'] = $wilayah;
            $data['title'] = "Lihat Rincian \"{$event->event_name}\" &mdash; " . config('app.name');

            return view('admin.event-view', $data);
        } else {
            return redirect()->route('admin.event-main')->with('error', 'Data dengan id "' . $id . ' ');
        }
    }

    /**
     * Data Addition
     */
    function add()
    {
        $data['title'] = 'Tambah Data &mdash; ' . config('app.name');
        return view('admin.event-add', $data);
    }
    function addProcess(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            "event_name"    => 'required',
            "id_user"       => 'required',
            "category"      => 'required',
            "event_do"      => 'required',
            "start_date"    => 'required',
            "end_date"      => 'required',
            "status"        => 'required',
            "event_type"    => 'required',
            "logo"          => 'mimes:png,jpg|max:3300',
            "banner"        => 'mimes:png,jpg|max:5700',
            "url"           => $request->input('event_do') == 'online' ? 'required' : '',
            "provinsi"      => $request->input('event_do') == 'offline' ? 'required' : '',
            "kabupaten"     => $request->input('event_do') == 'offline' ? 'required' : '',
            "kecamatan"     => $request->input('event_do') == 'offline' ? 'required' : '',
            "kelurahan"     => $request->input('event_do') == 'offline' ? 'required' : '',
            "alamat"        => $request->input('event_do') == 'offline' ? 'required' : '',
        ], [
            "url.required"          => "Anda harus mengisi kolom URL Kegiatan Online!",
            "provinsi.required"     => "Anda harus memilih kolom Provinsi!",
            "kabupaten.required"    => "Anda harus memilih kolom Kabupaten!",
            "kecamatan.required"    => "Anda harus memilih kolom Kecamatan!",
            "kelurahan.required"    => "Anda harus memilih kolom Kelurahan!",
            "alamat.required"       => "Anda harus memilih kolom Alamat!",
            "event_name.required"   => 'Anda harus mengisi kolom Nama Event!',
            "id_user.required"      => 'Anda harus memilih Siapa Pembuat Eventnya!',
            "category.required"     => 'Anda harus memilih Kategori Eventnya!',
            "event_do.required"     => 'Anda harus memilih kegiatan online/offline!',
            "start_date.required"   => 'Anda harus mengisi tanggal awal kegiatan!',
            "end_date.required"     => 'Anda harus mengisi tanggal akhir kegiatan!',
            "status.required"       => 'Anda harus memilih status kegiatan!',
            "event_type.required"   => 'Anda harus memilih kegiatan berbayar/gratis!',
            "logo.max"              => 'Ukuran Logo melebihi kriteria maksimal 3MB!',
            "logo.mimes"            => 'Unggahan Logo anda tidak sesuai kriteria pengunggahan gambar!',
            "banner.max"            => 'Ukuran Logo melebihi kriteria maksimal 5MB!',
            "banner.mimes"          => 'Unggahan Banner anda tidak sesuai kriteria pengunggahan gambar!',
        ]);

        if(!$validator->fails()) {
            $data = $request->only(['event_name', 'id_user', 'category', 'event_desc', 'event_desc_short', 'event_do', 'url', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'alamat', 'status', 'event_type']);

            // Select Data
            if($data['event_do'] == 'offline') {
                unset($data['url']);
            } else {
                unset($data['alamat'], $data['kecamatan'], $data['kelurahan'], $data['kabupaten'], $data['provinsi']);
            }

            // Data ID
            $data['event_id'] = Str::lower(Str::replace(' ', '-', $data['event_name']));

            // Tos
            if($request->input('tos')) :
                $tos = $request->input('tos');
                $num =  0;
                foreach($tos as $index => $toss) {
                    $tosss[$num] = $toss;
                }
                $data['event_tos'] = json_encode($tosss);
            endif;

            // Date
            $data['start_date'] = Carbon::parse($request->input('start_date'))->format('Y-m-d');
            $data['end_date'] = Carbon::parse($request->input('end_date'))->format('Y-m-d');
            $data['start_time'] = Carbon::parse($request->input('start_date'))->format('H:i:s');
            $data['end_time'] = Carbon::parse($request->input('end_date'))->format('H:i:s');

            // Upload Image
            if($request->file('logo')) {
                $file = $request->file('logo');
                $ext  = $file->getClientOriginalExtension();
                $unik = uniqid('img-');
                $nama_file = "{$unik}.{$ext}";
                $upload = public_path('upload');

                $file->move($upload, $nama_file);

                $data['thumbnail'] = "upload/{$unik}.{$ext}";
            }
            if($request->file('banner')) {
                $file = $request->file('banner');
                $ext  = $file->getClientOriginalExtension();
                $unik = uniqid('img-');
                $nama_file = "{$unik}.{$ext}";
                $upload = public_path('upload');

                $file->move($upload, $nama_file);

                $data['event_banner'] = "upload/{$unik}.{$ext}";
            }

            try {
                if($event->create($data)) {
                    return response()->json([
                        'error' => false,
                        'code' => 200,
                        'csrf'    => csrf_token(),
                        'message' => 'Data berhasil ditambahkan, sistem akan mengarahkan ke halaman detail eventnya!',
                        'redirect' => route('admin.event-detail', $data['event_id']),
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'code' => 500,
                        'csrf'    => csrf_token(),
                        'message' => 'Ada kesalahan dalam memasukkan data ke database! Ulangi beberapa saat lagi ya?',
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'code' => 500,
                    'csrf'    => csrf_token(),
                    'message' => 'Ada kesalahan dalam memasukkan data ke database! Ulangi beberapa saat lagi ya?',
                    'err' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'error' => true,
                'code' => 500,
                'csrf'    => csrf_token(),
                'message' => 'Ada beberpa inputan yang dirasa kurang oleh sistem! Cek ya?',
                'data' => $validator->errors()->all(),
            ], 500);
        }
    }

    /**
     * Ajax Data
     */
    function getUser(Request $request, User $users)
    {
        $ajax = $request->ajax();
        $id   = $request->username;
        $user = $users-> where('fullname', "LIKE", "%{$id}%");

        if($ajax) {
            if($user->count() > 0) {
                return response()->json([
                    'data'    => $user->get(),
                    'status'  => 200,
                    'csrf'    => csrf_token(),
                    'message' => 'Data berhasil diambil dan pengguna ditemukan!',
                ], 200);
            } else {
                return response()->json([
                    'data'    => [],
                    'status'  => 500,
                    'csrf'    => csrf_token(),
                    'message' => 'Data berhasil diambil namum pengguna tidak dapat ditemukan!',
                ], 200);
            }
        } else {
            return redirect()->route('home')->with('error', 'Anda tidak diizinkan mengakses halaman tadi!');
        }
    }
    function addCategory(Categories $cat, Request $request)
    {
        $ajax = $request->ajax();
        $name = $request->cat_name;
        $slug = Str::lower(Str::replace(' ', '-', $name));

        if($ajax) {
            $data = (array) [
                'cat_name' => $name,
                'slug' => $slug,
            ];
            return response([
                'data' => $cat->firstOrCreate($data),
                'token' => csrf_token()
            ]);
        } else {
            return redirect()->route('home')->with('error', 'Anda tidak diizinkan mengakses halaman tadi!');
        }
    }
    function getCategory(Request $request, Categories $cat)
    {
        $ajax = $request->ajax();
        $id   = $request->category;
        $cat = $cat->where('cat_name', "LIKE", "%{$id}%");

        if($ajax) {
            if($cat->count() > 0) {
                return response()->json([
                    'data'    => $cat->get(),
                    'status'  => 200,
                    'csrf'    => csrf_token(),
                    'message' => 'Data berhasil diambil dan pengguna ditemukan!',
                ], 200);
            } else {
                return response()->json([
                    'data'    => [],
                    'status'  => 500,
                    'csrf'    => csrf_token(),
                    'message' => 'Data berhasil diambil namum pengguna tidak dapat ditemukan!',
                ], 200);
            }
        }
    }


    /**
     * Editing Data
     */
    function edit($id, Event $event, Wilayah $wilayah)
    {
        $search = $event->where('event_id', $id);
        $count  = $search->count();
        $datas  = $count > 0 ? (object) $search->first() : null;

        if($count > 0)
        {
            $event = $datas->first();
            $data['event'] = $event;
            $data['wilayah'] = $wilayah;
            $data['author'] = $data['event']->getUsers()->first();

            $data['title'] = "Edit Event \"{$event->event_name}\" &mdash; " . config('app.name');
            return view('admin.event-edit', $data);
        } else {
            return redirect()->route('admin.event-main')->with('error', 'Data kegiatan dengan id "' . $id . '" tidak ditemukan!');
        }
    }
    function editData(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            "event_name"    => 'required',
            "id_user"       => 'required',
            "category"      => 'required',
            "event_do"      => 'required',
            "start_date"    => 'required',
            "end_date"      => 'required',
            "status"        => 'required',
            "event_type"    => 'required',
            "url"           => $request->input('event_do') == 'online' ? 'required' : '',
            "provinsi"      => $request->input('event_do') == 'offline' ? 'required' : '',
            "kabupaten"     => $request->input('event_do') == 'offline' ? 'required' : '',
            "kecamatan"     => $request->input('event_do') == 'offline' ? 'required' : '',
            "kelurahan"     => $request->input('event_do') == 'offline' ? 'required' : '',
            "alamat"        => $request->input('event_do') == 'offline' ? 'required' : '',
            "logo"          => 'mimes:png,jpg|max:3300',
            "banner"        => 'mimes:png,jpg|max:5700',
        ], [
            "url.required"          => "Anda harus mengisi kolom URL Kegiatan Online!",
            "provinsi.required"     => "Anda harus memilih kolom Provinsi!",
            "kabupaten.required"    => "Anda harus memilih kolom Kabupaten!",
            "kecamatan.required"    => "Anda harus memilih kolom Kecamatan!",
            "kelurahan.required"    => "Anda harus memilih kolom Kelurahan!",
            "alamat.required"       => "Anda harus memilih kolom Alamat!",

            "event_name.required"   => 'Anda harus mengisi kolom Nama Event!',
            "id_user.required"      => 'Anda harus memilih Siapa Pembuat Eventnya!',
            "category.required"     => 'Anda harus memilih Kategori Eventnya!',
            "event_do.required"     => 'Anda harus memilih kegiatan online/offline!',
            "start_date.required"   => 'Anda harus mengisi tanggal awal kegiatan!',
            "end_date.required"     => 'Anda harus mengisi tanggal akhir kegiatan!',
            "status.required"       => 'Anda harus memilih status kegiatan!',
            "event_type.required"   => 'Anda harus memilih kegiatan berbayar/gratis!',
            "logo.max"              => 'Ukuran Logo melebihi kriteria maksimal 3MB!',
            "logo.mimes"            => 'Unggahan Logo anda tidak sesuai kriteria pengunggahan gambar!',
            "banner.max"            => 'Ukuran Logo melebihi kriteria maksimal 5MB!',
            "banner.mimes"          => 'Unggahan Banner anda tidak sesuai kriteria pengunggahan gambar!',
        ]);

        if(!$validator->fails()) {
            $update = $event->where('event_id', $request->event_id);
            $datas = $update->first();
            $data = $request->only(['event_name', 'id_user', 'category', 'event_desc', 'event_desc_short', 'event_do', 'url', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'alamat', 'status', 'event_type']);

            // Select Data
            if($data['event_do'] == 'offline') {
                unset($data['url']);
            } else {
                unset($data['alamat'], $data['kecamatan'], $data['kelurahan'], $data['kabupaten'], $data['provinsi']);
            }

            // Data ID
            $data['event_id'] = Str::lower(Str::replace(' ', '-', $data['event_name']));

            // Tos
            if($request->input('tos')) :
                $tos = $request->input('tos');
                $num =  0;
                foreach($tos as $index => $toss) {
                    $tosss[$num] = $toss;
                }
                $data['event_tos'] = json_encode($tosss);
            endif;

            // Date
            $data['start_date'] = Carbon::parse($request->input('start_date'))->format('Y-m-d');
            $data['end_date'] = Carbon::parse($request->input('end_date'))->format('Y-m-d');
            $data['start_time'] = Carbon::parse($request->input('start_date'))->format('H:i:s');
            $data['end_time'] = Carbon::parse($request->input('end_date'))->format('H:i:s');

            // Upload Image
            if($request->file('logo')) {
                $file = $request->file('logo');
                $ext  = $file->getClientOriginalExtension();
                $unik = uniqid('img-');
                $nama_file = "{$unik}.{$ext}";
                $upload = public_path('upload');

                $file->move($upload, $nama_file);

                $data['thumbnail'] = "upload/{$unik}.{$ext}";
            } else {
                $data['event_banner'] = $datas->thumbnail;
            }
            if($request->file('banner')) {
                $file = $request->file('banner');
                $ext  = $file->getClientOriginalExtension();
                $unik = uniqid('img-');
                $nama_file = "{$unik}.{$ext}";
                $upload = public_path('upload');

                $file->move($upload, $nama_file);

                $data['event_banner'] = "upload/{$unik}.{$ext}";
            } else {
                $data['event_banner'] = $datas->event_banner;
            }

            try {
                $ticks_update['event_id'] = $data['event_id'];
                if($data['event_type'] == 'free') :
                    $ticks_update['price'] = 0;
                endif;

                Ticket::where('event_id', $request->event_id)->update($ticks_update);

                if($update->update($data)) {
                    return response()->json([
                        'error' => false,
                        'code' => 200,
                        'csrf'    => csrf_token(),
                        'message' => 'Data berhasil ditambahkan, sistem akan mengarahkan ke halaman detail eventnya!',
                        'redirect' => route('admin.event-detail', $data['event_id']),
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'code' => 500,
                        'csrf'    => csrf_token(),
                        'message' => 'Ada kesalahan dalam memasukkan data ke database! Ulangi beberapa saat lagi ya?',
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'code' => 500,
                    'csrf'    => csrf_token(),
                    'message' => 'Ada kesalahan dalam memasukkan data ke database! Ulangi beberapa saat lagi ya?',
                    'err' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'error' => true,
                'code' => 500,
                'csrf'    => csrf_token(),
                'message' => 'Ada beberpa inputan yang dirasa kurang oleh sistem! Cek ya?',
                'data' => $validator->errors()->all(),
            ], 500);
        }
    }
}
