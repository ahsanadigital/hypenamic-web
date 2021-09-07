<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ticket = new Ticket();

        $data['id_ticket']              = uniqid('ticket-');
        $data['ticket_name']            = 'Pendaftaran Peserta';
        $data['stok']                   = 15;
        $data['description_tiket']      = 'Peserta harap mendaftarkan diri sebelum tanggal yang tertera pada tiket ini.';
        $data['event_id']               = Str::lower(str_replace('.', '', str_replace(['/', "'", ' '], '-', 'Pelatihan Desain Grafis Batch 1')));
        $data['price']                  = 225000;
        $data['expiry_on']              = 'kegiatan';
        $data['end_date']               = '2021-08-31';
        $data['status']                 = 'open';

        $ticket->create($data);

        $data['id_ticket']              = uniqid('ticket-');
        $data['ticket_name']            = 'Pendaftaran Peserta Pagi';
        $data['stok']                   = 1000;
        $data['description_tiket']      = 'Bagian pagi mulai pukul 08.00 - 11.30 WIB.';
        $data['event_id']               = Str::lower(str_replace('.', '', str_replace(['/', "'", ' '], '-', 'Vaksinasi massal')));
        $data['price']                  = 0;
        $data['expiry_on']              = 'besok';
        $data['end_date']               = '2021-08-31';
        $data['status']                 = 'open';

        $ticket->create($data);
    }
}
