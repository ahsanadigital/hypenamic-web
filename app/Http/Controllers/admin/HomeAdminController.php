<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    function main()
    {
        $data['title'] = 'Beranda Admin &mdash; ' . config('app.name');
        return view('admin.home', $data);
    }
}
