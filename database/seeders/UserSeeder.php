<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data   = new User();

        $user['id_user']        = 'hypenamic_studio';
        $user['username']       = 'hypenamic_studio';
        $user['email']          = 'hypenamic@gmail.com';
        $user['number_phone']   = '085731110286';
        $user['password']       = bcrypt('HypenamicStudio2021');

        $user['fullname']       = 'Hypenamic Studio';
        $user['institution']    = 'CV. Aldi Production';
        $user['foto_profil']    = null;
        $user['banner_eo']      = null;
        $user['instagram']      = 'https://www.instagram.com/hypenamic';
        $user['twitter']        = 'https://www.hypenamic.com/hypenamic';
        $user['facebook']       = 'https://www.facebook.com/hypenamic';
        $user['whatsapp']       = 'https://api.whatsapp.com/send?phone=6285731110286';

        $user['status']         = 'on';
        $user['type']           = 'admin';

        $user['alamat']         = 'Jl. Pagesangan Asri 1 AA 51';
        $user['kelurahan']      = 3578231004;
        $user['kecamatan']      = 357823;
        $user['kabupaten']      = 3578;
        $user['provinsi']       = 35;

        $data->create($user);
    }
}
