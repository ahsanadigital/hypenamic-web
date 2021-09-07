<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function main(Carbon $carbon, Event $events, Wilayah $wilayah)
    {
        $data['events']     = $events->select(['event_name', 'event_id', 'start_date', 'event_desc_short', 'provinsi', 'kabupaten', 'event_banner', 'event_type'])->orderBy('created_at', 'DESC')->limit(12)->get();
        $data['highlight']  = $events->where('highlight', 1)->select(['event_name', 'provinsi', 'kabupaten', 'event_id', 'id_user', 'start_date', 'event_desc', 'provinsi', 'kabupaten', 'event_banner', 'event_do', 'event_type'])->orderBy('created_at', 'DESC')->limit(5);

        $data['carbon']     = $carbon;
        $data['wilayah']    = $wilayah;
        $data['title']      = 'Halaman Depan &mdash; ' . config('app.name');
        return view('home', $data);
    }

    function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();

        return redirect()->route('home');
    }

    function pricing() {
        $data['title'] = 'Harga Layanan &mdash; ' . config('app.name');
        return view('pricing', $data);
    }

    function privasi() {
        $data['title'] = 'Kebijakan Privasi &mdash; ' . config('app.name');
        return view('privasi', $data);
    }

    function tos() {
        $data['title'] = 'Syarat dan Ketentuan &mdash; ' . config('app.name');
        return view('tos', $data);
    }
}
