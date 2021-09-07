<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event = new Event();

        // Data 1 ==================================================

        $data['event_id']           = Str::lower(str_replace('.', '', str_replace(['/', "'", ' '], '-', 'Pelatihan Desain Grafis Batch 1')));
        $data['event_banner']       = null;
        $data['thumbnail']          = null;

        $data['event_name']         = 'Pelatihan Desain Grafis Batch 1';
        $data['event_desc']         = 'Pelatihan Desain Grafis dengan CorelDraw bagian pertama untuk melatih dan meningkatkan skill kamu dalam membuat desain dengan CorelDraw.';
        $data['event_desc_short']   = 'Pelatihan desain grafis menggunakan CorelDraw';
        $data['event_tos']          = '[{"title":"Peserta harus memiliki satu laptop.","desc":"Demi kelancaran dalam pelatihan desain, diharapkan peserta memiliki laptop sendiri.."}]';
        $data['id_user']            = 'hypenamic_studio';
        $data['start_date']         = '2021-08-25';
        $data['end_date']           = '2021-08-31';
        $data['start_time']         = '14:00:00';
        $data['end_time']           = '16:00:00';

        $data['category']           = 'desain-grafis';

        $data['kabupaten']          = null;
        $data['provinsi']           = null;

        $data['event_do']           = 'online';
        $data['event_type']         = 'bayar';
        $data['status']             = 'open';

        $event->create($data);

        // Data 2 ==================================================

        $data['event_id']           = Str::lower(str_replace('.', '', str_replace(['/', "'", ' '], '-', 'Vaksinasi Massal')));
        $data['event_banner']       = null;
        $data['thumbnail']          = null;

        $data['event_name']         = 'Vaksinasi Massal';
        $data['event_desc']         = 'Pelatihan Desain Grafis dengan CorelDraw bagian pertama untuk melatih dan meningkatkan skill kamu dalam membuat desain dengan CorelDraw.';
        $data['event_desc_short']   = 'Pelatihan desain grafis menggunakan CorelDraw';
        $data['event_tos']          = '[{"title":"Peserta harus memiliki satu laptop.","desc":"Demi kelancaran dalam pelatihan desain, diharapkan peserta memiliki laptop sendiri.."}]';
        $data['id_user']            = 'hypenamic_studio';
        $data['start_date']         = '2021-08-04';
        $data['end_date']           = '2021-08-13';
        $data['start_time']         = '14:00:00';
        $data['end_time']           = '16:00:00';

        $data['category']           = 'desain-grafis';

        $data['kelurahan']          = 3578261002;
        $data['kecamatan']          = 357826;
        $data['kabupaten']          = 3578;
        $data['provinsi']           = 35;

        $data['event_do']           = 'offline';
        $data['event_type']         = 'free';
        $data['status']             = 'open';

        $event->create($data);
    }
}
