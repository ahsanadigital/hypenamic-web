<?php

namespace App\Http\Controllers;

use App\Models\StoreTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;

class InvoiceController extends Controller
{
    /**
     * Menampilkan beranda cek tagihan
     */
    function main()
    {
        $data['title'] = 'Cek Tagihan &mdash; ' . config('app.name');
        return view('pay-main', $data);
    }

    /**
     * Aksi pencarian data tagihan
     */
    function check(Request $request, Transaction $trans)
    {
        if ($request->get('id_tagihan')) {
            $id      = $request->get('id_tagihan');
            $tagihan = $trans->where('invoice_id', $id);

            if ($tagihan->count() > 0) {
                $data = $tagihan->first();
                if ($data->ammount > 0 && $data->token !== '') {
                    try {

                        Config::$serverKey = config('midtrans.payment.server_key');
                        Config::$isProduction = config('midtrans.payment.production');

                        $status = \Midtrans\Transaction::status($data->invoice_id);
                        $req = $request->all();
                        $trans          = new Transaction();
                        $store          = new StoreTransaction();
                        $data_change    = $trans->where('invoice_id', $status->order_id);
                        $datas          = $data_change->first();
                        $data_change->update(['status' => $status->transaction_status]);

                        if($status->transaction_status == 'settlement' OR $status->transaction_status == 'capture')
                        {
                            $req            = array_merge($req, $datas->toArray());

                            $tiket          = $datas->getTicket()->first();
                            $event          = $tiket->getEvent()->first();

                            $req            = array_merge($req, ['event' => $tiket]);
                            $req            = array_merge($req, ['tiket' => $event]);

                            // Send The Email ============================================================
                            $checks = $store->where('id_transaksi', $status->order_id);
                            if ($checks->count() > 0) :
                                $check = $checks->get();
                                Mail::send('email.success', $req, function ($message) use ($req, $check) {
                                    $message->subject('Tiket Anda');
                                    $message->from(config('mail.from.address'), config('mail.from.name'));
                                    $message->to($req['email'], "{$req['first_name']} {$req['last_name']}");

                                    foreach ($check as $datas) {
                                        $tiket          = $datas->getTicket()->first();
                                        $event          = $tiket->getEvent()->first();

                                        $req            = array_merge($req, ['event' => $tiket]);
                                        $req            = array_merge($req, ['tiket' => $event]);
                                        $req            = array_merge($req, ['ticks' => $datas->ticket_hash]);

                                        $pdf = PDF::setOptions([
                                            'isHtml5ParserEnabled'  => true,
                                            'isPhpEnabled'          => true,
                                            'isRemoteEnabled'       => true
                                        ]);
                                        $pdf->loadView('pdf.ticket', $req)->setPaper('a4', 'landscape');
                                        $pdf->getDomPDF()->setHttpContext(
                                            stream_context_create([
                                                'ssl' => [
                                                    'allow_self_signed' => TRUE,
                                                    'verify_peer'       => FALSE,
                                                    'verify_peer_name'  => FALSE,
                                                ]
                                            ])
                                        );
                                        $message->attachData($pdf->output(), "{$req['ticks']}.pdf");
                                    }
                                });
                                return redirect()->route('notify.success-alt');
                            else :
                                Mail::send('email.success', $req, function ($message) use ($req, $store) {
                                    $message->subject('Tiket Anda');
                                    $message->from(config('mail.from.address'), config('mail.from.name'));
                                    $message->to($req['email'], "{$req['first_name']} {$req['last_name']}");

                                    for ($i = 1; $i <= $req['qty']; $i++) {
                                        $req    = array_merge($req, ['ticks' => uniqid()]);

                                        $store->create([
                                            'email'        => $req['email'],
                                            'ticket_hash'  => $req['ticks'],
                                            'id_transaksi' => $req['invoice_id'],
                                            'first_name'   => $req['first_name'],
                                            'last_name'    => $req['last_name'],
                                            'email'        => $req['email'],
                                            'ticket_id'    => $req['ticket_id'],
                                            'phone_number' => $req['phone_number'],
                                        ]);
                                        // Send to Database

                                        $pdf = PDF::setOptions([
                                            'isHtml5ParserEnabled'  => true,
                                            'isPhpEnabled'          => true,
                                            'isRemoteEnabled'       => true
                                        ]);
                                        $pdf->loadView('pdf.ticket', $req)->setPaper('a4', 'landscape');
                                        $pdf->getDomPDF()->setHttpContext(
                                            stream_context_create([
                                                'ssl' => [
                                                    'allow_self_signed' => TRUE,
                                                    'verify_peer'       => FALSE,
                                                    'verify_peer_name'  => FALSE,
                                                ]
                                            ])
                                        );
                                        $message->attachData($pdf->output(), "{$req['ticks']}.pdf");
                                    }
                                });
                                return redirect()->route('notify.success');
                            endif;
                        } else {

                        }
                    } catch (\Exception $e) {
                        return redirect()->route('invoice-pay', $id);
                    }
                } else {

                }
            } else {
                return redirect()->route('invoice-main')->with('warning', 'ID Tagihan yang anda cari tidak tercatat dalam database! Silahkan cek kembali ejaannya!');
            }
        } else {
            return redirect()->route('invoice-main')->with('error', 'Masukkan ID Tagihan terlebih dahulu!');
        }
    }

    /**
     * Untuk menjalankan fungsi payment dengan midtrans payment gateway.
     */
    function pay($id = null)
    {
        $trans = new Transaction();
        $carbon = new Carbon();

        Config::$serverKey = config('midtrans.payment.server_key');
        Config::$isProduction = config('midtrans.payment.production');

        $query = $trans->where('invoice_id', $id);
        if ($query->count() > 0) {
            $q = $query->first();

            if ($carbon->timestamp >= $carbon->parse($q->created_at)->addDays(1)->timestamp) {
                return redirect()->route('home');
            }

            $query = $query->select(['status', 'ammount', 'invoice_id', 'token', 'status', 'first_name', 'ticket_id', 'last_name', 'phone_number'])->first();
            $tiket = $query->getTicket()->select(['ticket_name', 'event_id']);
            $data['invoice']    = $query;
            $data['ticket']     = $tiket->first();
            $data['event']      = $tiket->first()->getEvent()->select(['event_name', 'event_id'])->first();
            $data['title']      = "Bayar Tagihan {$id} &mdash; " . config('app.name');

            return view('pay', $data);
        } else {
            return redirect()->route('invoice-main')->with('error', 'Tagihan dengan ID #' . $id . ' tidak dapat kami temukan.');
        }
    }
}
