<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginAdminController extends Controller
{
    function login()
    {
        $data['title'] = 'Masuk Dahulu &mdash; ' . config('app.name');
        return view('admin.login', $data);
    }

    function process(Request $request, Auth $auth)
    {
        $input    = $request->only(['username', 'password']);
        $input['type'] = 'admin';
        $remember = $request->only('remember');
        $auth     = Auth::attempt($input, $remember);
        $validate = Validator::make($request->all(), [
            'username'          => 'required|min:5',
            'password'          => 'required|min:6',
        ], [
            'username.required' => 'Nama pengguna harap diisi!',
            'username.required' => 'Kata sandi harap diisi!',

            'username.min'      => 'Nama pengguna minimal ada 5 karakter!',
            'password.min'      => 'Kata sandi minimal ada 5 karakter!',
        ]);

        if($validate->fails()) {
            return response()->json([
                'error'         => true,
                'message'       => 'Mohon periksa kembali isian data anda. Karena masih ada yang kosong!',
                'code'          => 403,
            ], 401);
        } else {
            if($auth) {
                return response()->json([
                    'error'     => false,
                    'message'   => 'Anda berhasil terautentikasi! Sistem akan mengarahkan anda ke halaman administrator!',
                    'redirect'  => route('admin.main'),
                    'code'      => 200,
                ], 200);
            } else {
                return response()->json([
                    'error'     => true,
                    'message'   => 'Mohon periksa kembali ejaan kata sandi dan nama pengguuna anda!',
                    'code'      => 401,
                ], 401);
            }
        }
    }
}
