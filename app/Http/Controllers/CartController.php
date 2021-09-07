<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\StoreTransaction;
use App\Models\Ticket;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

class CartController extends Controller
{
    # For Cart =====================================================================================

    /**
     * Add to Cart
     * Aksi menambahkan data ke keranjang
     */
    function cart(Request $request)
    {
        $input = $request->except('_token');
        if($input['value'] > '0') {
            $cart = $request->session()->get('cart', []);

            $cart['id_ticket'] = $input['id_ticket'];
            $cart['name'] = $input['name'];
            $cart['price'] = $input['price'];
            $cart['value'] = $input['value'];

            $request->session()->put('cart', $cart);

            return response()->json([
                'status'   => 'success',
                'code'     => 200,
                'message'  => 'Tiket telah ditambahkan kedalam keranjang pembelian anda! Sistem akan mengarahkan anda ke halaman keranjang belanjaan.',
                'title'    => 'Berhasil Menambahkan!',
                'redirect' => route('checkout'),
            ], 200);
        } else {
            return response()->json([
                'status'   => 'error',
                'code'     => 400,
                'message'  => 'Maaf, sistem gagal menambahkan tiket ke keranjang pembelian. Karena anda tidak menambahkan apapun ke dalam keranjang!',
                'title'    => 'Gagal Menambahkan!',
            ], 400);
        }
    }

    /**
     * Menghapus semua keranjang
     */
    function truncate(Request $request)
    {
        $request->session()->forget('cart');
        return redirect()->route('jelajah');
    }

    # For Checkout =================================================================================
    /**
     * Untuk Proses checkout
     */
    function checkout(Request $request, Ticket $ticket, Helper $helper) {
        $cart = $request->session()->get('cart', []);

        if(!$cart) {
            return redirect()->route('home');
        } else {
            $data['ticket'] = $ticket->where('id_ticket', $cart['id_ticket'])->select(['event_id'])->first();
            $data['title']  = 'Checkout &mdash; ' . config('app.name');
            $data['cart']   = $request->session()->get('cart', (array) []);
            $data['helper'] = $helper;

            return view('cart-checkout', $data);
        }
    }

    function proses (Request $request, Transaction $transaksi, Ticket $ticket)
    {
        if($request->session()->get('cart', [])) {
            $cart = $request->session()->get('cart', []);
            $req = $request->except(['_token', 'agreements']);

            if($req['ammount'] > 0) {
                $req = array_merge($req, ['invoice_id' => uniqid('HE-')]);

                // Update Ticket Value =======================================================
                $check = $ticket->where('id_ticket', $req['id_ticket'])->first();
                $value = $check->stok;
                $checks =  $value - $cart['value'];
                $check->update(['stok' => $checks]);
                // Update Ticket Value =======================================================

                // Midtrans Payment Config ===================================================
                Config::$serverKey = config('midtrans.payment.server_key');
                Config::$isProduction = config('midtrans.payment.production');

                $params = array(
                    'transaction_details'   => array(
                        'order_id'          => $req['invoice_id'],
                        'gross_amount'      => $req['ammount'],
                    ),
                    'customer_details'      => array(
                        'first_name'        => $req['first_name'],
                        'last_name'         => $req['last_name'],
                        'email'             => $req['email'],
                        'phone'             => $req['nomor_hp'],
                    ),
                );
                $key = Snap::getSnapToken($params);
                // Midtrans Payment Config ===================================================

                // Store to DB ===============================================================
                $array = [
                    'invoice_id'            => $req['invoice_id'],
                    'ticket_id'             => $req['id_ticket'],
                    'status'                => 'pending',
                    'ammount'               => $req['ammount'],
                    'token'                 => $key,
                    'qty'                   => $cart['value'],
                    'callback'              => false,
                    'first_name'            => $req['first_name'],
                    'last_name'             => $req['last_name'],
                    'email'                 => $req['email'],
                    'phone_number'          => $req['nomor_hp'],
                ];
                $transaksi->create($array);
                // Store to DB ===============================================================

                $req = array_merge($req, $cart);

                // Send The Email ============================================================
                try {
                    Mail::send('email.invoice', $req, function ($message) use ($req)
                    {
                        $message->subject('Faktur Tagihan');
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                        $message->to($req['email'], "{$req['first_name']} {$req['last_name']}");
                    });
                } catch (Exception $e){
                    return response (['status' => false, 'errors' => $e->getMessage()]);
                }
                // Send The Email ============================================================

                $request->session()->forget('cart');

                return redirect()->route('invoice-pay', $req['invoice_id']);
            } else {
                $req = array_merge($req, ['invoice_id' => uniqid('HE-')]);
                $req = array_merge($req, $cart);

                $check = $ticket->where('id_ticket', $req['id_ticket'])->first();
                $event = $check->getEvent()->first();

                $req = array_merge($req, ['tiket' => $check]);
                $req = array_merge($req, ['event' => $event]);

                // Update Ticket Value =======================================================
                $check = $ticket->where('id_ticket', $req['id_ticket'])->first();
                $value = $check->stok;
                $checks =  $value - $cart['value'];
                $check->update(['stok' => $checks]);
                // Update Ticket Value =======================================================

                // Store to DB ===============================================================
                $array = [
                    'invoice_id'            => $req['invoice_id'],
                    'ticket_id'             => $req['id_ticket'],
                    'status'                => 'settlement',
                    'ammount'               => 0,
                    'token'                 => null,
                    'callback'              => false,
                    'qty'                   => $cart['value'],
                    'first_name'            => $req['first_name'],
                    'last_name'             => $req['last_name'],
                    'email'                 => $req['email'],
                    'phone_number'          => $req['nomor_hp'],
                ];
                $req = array_merge($req, ['invoice' => $transaksi->create($array)->toArray()]);
                // Store to DB ===============================================================

                // Send The Email ============================================================
                Mail::send('email.success', $req, function ($message) use ($req)
                {
                    $message->subject('Tiket Anda');
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                    $message->to($req['email'], "{$req['first_name']} {$req['last_name']}");

                    for ($i=0; $i < $req['value']; $i++) {
                        $req = array_merge($req, ['ticks' => uniqid()]);
                        $store = new StoreTransaction();

                        // Send to Database
                        $store->create([
                            'email'        => $req['email'],
                            'ticket_hash'  => $req['ticks'],
                            'id_transaksi' => $req['invoice']['invoice_id'],
                            'first_name'   => $req['first_name'],
                            'last_name'    => $req['last_name'],
                            'email'        => $req['email'],
                            'phone_number' => $req['nomor_hp'],
                            'ticket_id'    => $req['id_ticket'],
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
                // Send The Email ============================================================

                unset($req);
                $request->session()->forget('cart');

                return redirect()->route('notify.success');
            }
        } else {
            return redirect()->route('home');
        }
    }
}
