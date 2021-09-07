@extends('templates.invoice')

@section('container')
<div class="container">
    <div class="row justify-content-center min-vh-100 py-5 align-items-center">
        <div class="col-md-5">
            <div class="card shadow card-body border-0">
                <a href="{{ route('home') }}" class="d-block w-100 mb-5">
                    <img src="{{ asset('assets/images/brands/hypenamic-event-color.png') }}" height="90px" class="p-2 mb-n5 mt-n5 mx-auto d-block">
                </a>

                <h3 class="text-center">Pembayaran</h3>
                <p class="text-center">Silahkan melakukan transaksi pembayaran di halaman ini.</p>

                <div class="card mb-3">
                    <table class="table-striped table-borderless m-0 table">
                        <tbody>
                            <tr>
                                <th>Nama Pembeli</th>
                                <td>{{ "{$invoice->first_name} {$invoice->last_name}" }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Yang Dibayar</th>
                                <td>Rp {{ number_format($invoice->ammount, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($invoice->status == 'pending')
                                    <span class="badge badge-warning">Menunggu Pembayaran</span>
                                    @elseif ($invoice->status == 'settlement'|| $invoice->status == 'capture')
                                    <span class="badge badge-success">Berhasil</span>
                                    @elseif ($invoice->status == 'cancel')
                                    <span class="badge badge-danger">Dibatalkan</span>
                                    @elseif ($invoice->status == 'failure')
                                    <span class="badge badge-danger">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Pembayaran</th>
                                <td><strong>{{ $ticket->ticket_name }}</strong> pada <strong>{{ $event->event_name }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if ($invoice->status == 'pending')
                <button type="button" class="btn btn-block bayar btn-primary"><i class="fas fa-money-bill-alt mr-2 fa-fw"></i>Bayar</button type="button">
                <a href="{{ route('invoice-check') }}?id_tagihan={{ $invoice->invoice_id }}" class="btn btn-warning btn-block"><i class="fas fa-sync mr-2 fa-fw"></i>Cek Pembayaran</a>
                @endif
                <a href="{{ route('invoice-main') }}" class="btn btn-block btn-light"><i class="fas fa-arrow-left mr-2 fa-fw"></i>Kembali</a>
            </div>

            <div class="d-block mx-auto mt-3">
                <p class="text-center m-0">Hak Cipta {{ now()->format('Y') }}, <a href="{{ route('home') }}">{{ config('app.name') }}</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @if ($invoice->status !== 'settlement' || $invoice->status !== 'accept')
    <script type="text/javascript" src="{{ config('midtrans.payment.production') == false ? config('midtrans.payment.sand_url') : config('midtrans.payment.prod_url') }}" data-client-key="{{ config('midtrans.payment.client_key') }}"></script>

    <script>
    "use strict";

    $('.bayar').click(e => {
        try {
            window.snap.pay('{{ $invoice->token }}');
        } catch(e) {
            errorAlert.fire({
                icon: 'error',
                title: 'Kesalahan!',
                text: 'Ada kesalahan pada pengambilan data SnapToken dari database! Mungkin data tagihan anda memang data pembelian tiket gratis?',
            });
        }
    });
    </script>
    @endif
@endsection
