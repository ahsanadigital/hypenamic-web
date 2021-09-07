<?php

namespace App\Http\Controllers;

use App\Models\StoreTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;

class PaymentController extends Controller
{
    /**
     *  Finish Payment
     */
    function finish(Request $request)
    {
        $req = $request->all();
        if (!empty($req['transaction_status']) == 'pending') {
            $data['title'] = 'Masih Menunggu Pembayaran &mdash; ' . config('app.name');
            $data['input'] = $req;

            return view('status-pending', $data);
        } else {
            try {

                \Midtrans\Config::$serverKey = config('midtrans.payment.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.payment.production');

                $status         = \Midtrans\Transaction::status($req['id']);
                $trans          = new Transaction();
                $store          = new StoreTransaction();
                $data_change    = $trans->where('invoice_id', $status->order_id);
                $datas          = $data_change->first();
                $data_change->update(['status' => $status->transaction_status]);
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
            } catch (\Exception $e) {
                dd($e);
                return redirect()->route('invoice-main')->with('error', $e->getMessage() ? $e->getMessage() : 'Kesalahan tak terduga dari server midtrans! Sistem kami tidak dapat mencari datanya.');
            }
        }
    }

    /**
     * Notifikasi Payment Midtrans
     */
    function notifikasi()
    {
        $notif = new \Midtrans\Notification();
        dd($notif);

        $transaction = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        error_log("Order ID $notif->order_id: " . "transaction status = $transaction, fraud staus = $fraud");

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
            }
        } else if ($transaction == 'cancel') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
            }
        } else if ($transaction == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
        }
    }

    /**
     * Pending Payment
     */
    function pending()
    {
        $data['title'] = 'Menunggu Pembayaran &mdash; ' . config('app.name');
        return view('notifikasi-pending', $data);
    }

    /**
     * Error Payment
     */
    function error () {
        return redirect()->route('pay-error');
    }
}
