<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EventCategoryController extends Controller
{
    function main() {
        $data['title'] = 'Kategori Event &mdash; ' . config('app.name');
        return view('admin.event-category-main', $data);
    }
    function datatable(Categories $cat) {
        return Datatables::collection($cat->all())->toJson();
    }

    function edit(Categories $categories, Request $request) {
        $validate = Validator::make($request->all(), [
            'cat_name' => 'required',
        ], [
            'cat_name.required' => 'Kolom Nama Kategori Harap Diisi!',
        ]);

        if(!$validate->fails()) {
            $data['slug'] = Str::lower(Str::replace(' ', '-', $request->cat_name));
            $data['cat_name'] = $request->cat_name;

            $search = $categories->where('slug', $request->slug)->first();
            $search->getAllEvent()->update(['category' => $data['slug']]);
            $search->update($data);

            return response()->json([
                'error' => false,
                'code' => 200,
                'csrf'    => csrf_token(),
                'message' => 'Data berhasil ditambahkan, sistem akan memuat ulang data!',
            ], 200);
        } else {
            return response()->json([
                'error' => true,
                'code' => 500,
                'csrf'    => csrf_token(),
                'message' => 'Ada beberpa inputan yang dirasa kurang oleh sistem! Cek ya?',
                'data' => $validate->errors()->all(),
            ], 500);
        }
    }
    function delete(Categories $cat, $slug) {
        if($cat->where('slug', $slug)) {
            $cat->where('slug', $slug)->delete();

            return redirect()->route('admin.event-category-main')->with('success', 'Berhasil menghapus kategori!');
        }
        return redirect()->route('admin.event-category-main')->with('error', 'Gagal menghapus kategori!');
    }

    function add(Categories $categories, Request $request) {
        $validate = Validator::make($request->all(), [
            'cat_name' => 'required',
        ], [
            'cat_name.required' => 'Kolom Nama Kategori Harap Diisi!',
        ]);

        if(!$validate->fails()) {
            $data['slug'] = Str::lower(Str::replace(' ', '-', $request->cat_name));
            $data['cat_name'] = $request->cat_name;

            $search = $categories;
            $search->create($data);

            return response()->json([
                'error' => false,
                'code' => 200,
                'csrf'    => csrf_token(),
                'message' => 'Data berhasil ditambahkan, sistem akan memuat ulang data!',
            ], 200);
        } else {
            return response()->json([
                'error' => true,
                'code' => 500,
                'csrf'    => csrf_token(),
                'message' => 'Ada beberpa inputan yang dirasa kurang oleh sistem! Cek ya?',
                'data' => $validate->errors()->all(),
            ], 500);
        }
    }
}
