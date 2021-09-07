<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Wilayah extends Model
{
    /**
     * Get Data Provinsi
     * Mengambil data Provinsi berdasarkan API json
     *
     * @param int $number Untuk mencari data ID Provinsi
     *
     * @since 1.0.0-beta.2
     * @author Dasa Kreativa Studio
     * @package Siakad-SD-Negeri
     * @return \Illuminate\Support\Facades\Response::json
     */
    public function getProvinsi($number)
    {
        $pid      = (int) $number;
        $response = Http::withOptions(['verify' => false])
        ->get(asset('json/propinsi.json'));

        foreach($response->json() as $index => $value) {
            $val  = (int) $value['id'];
            if($val == $pid) {
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * Get Data Kabupaten
     * Mengambil data Kabupaten berdasarkan API json
     *
     * @param int $id_prov Untuk mencari data ID Provinsi
     * @param int $pid_data Untuk mencari data ID Kabupaten
     *
     * @since 1.0.0-beta.2
     * @author Dasa Kreativa Studio
     * @package Siakad-SD-Negeri
     * @return \Illuminate\Support\Facades\Response::json
     */
    public function getKabupaten($pid_prov, $pid_data)
    {
        $number   = (int) $pid_data;
        $pid_prov = (int) $pid_prov;

        $response = Http::withOptions(['verify' => false])
        ->get(asset('json/kabupaten/' . $pid_prov . '.json'));

        foreach($response->json() as $index => $value) {
            $val  = (int) $value['id'];
            if($val == $number) {
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * Get Data Kecamatan
     * Mengambil data Kecamatan berdasarkan API json
     *
     * @param int $id_kab Untuk mencari data ID Kabupaten
     * @param int $pid_data Untuk mencari data ID Kecamatan
     *
     * @since 1.0.0-beta.2
     * @author Dasa Kreativa Studio
     * @package Siakad-SD-Negeri
     * @return \Illuminate\Support\Facades\Response::json
     */
    public function getKecamatan($pid_kab, $pid_data)
    {
        $number   = (int) $pid_data;
        $pid_kab  = (int) $pid_kab;

        $response = Http::withOptions(['verify' => false])
        ->get(asset('json/kecamatan/' . $pid_kab . '.json'));

        foreach($response->json() as $index => $value) {
            $val  = (int) $value['id'];
            if($val == $number) {
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * Get Data Kelurahan
     * Mengambil data Kelurahan berdasarkan API json
     *
     * @param int $id_kec Untuk mencari data ID Kecamatan
     * @param int $pid_data Untuk mencari data ID Kelurahan
     *
     * @since 1.0.0-beta.2
     * @author Dasa Kreativa Studio
     * @package Siakad-SD-Negeri
     * @return \Illuminate\Support\Facades\Response::json
     */
    public function getKelurahan($pid_kec, $pid_data)
    {
        $number   = (int) $pid_data;
        $pid_kec  = (int) $pid_kec;

        $response = Http::withOptions(['verify' => false])
        ->get(asset('json/kelurahan/' . $pid_kec . '.json'));

        foreach($response->json() as $index => $value) {
            $val  = (int) $value['id'];
            if($val == $number) {
                $result = $value;
            }
        }

        return $result;
    }
}
