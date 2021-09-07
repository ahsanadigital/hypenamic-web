<?php

namespace App\Http\Controllers;

use App\Models\StoreTransaction;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VerifyTicket extends Controller
{
    function main($id, StoreTransaction $store)
    {
        $cek = $store->where('ticket_hash', $id);
        if($cek->count() > 0) {
            $tiket      = $cek->first();
            $data_tiket = $tiket->getTicket()->first();
            $event      = $data_tiket->getEvent()->first();
            $tiket      = (object) $tiket->toArray();
            $data_tiket = (object) $data_tiket->toArray();
            $event      = (object) $event->toArray();

            $data['title']      = 'Detail Tiket Anda &mdash; ' . config('app.name');
            $data['tiket']      = $tiket;
            $data['data_tiket'] = $data_tiket;
            $data['event']      = $event;
            $data['qr']         = QrCode::format('svg')->size(200);
            $data['wilayah']    = new Wilayah();

            return view('tiket-main', $data);
        } else {
            return redirect()->route('home')->with('error', 'Tiket dengan ID #' . $id . ' belum atau tidak terdaftar! Periksa kembali di email anda.');
        }
    }
}
