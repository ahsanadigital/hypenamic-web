<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiGlobalController extends Controller
{
    /**
     * Return Response Data Provinsi
     * Mengambil data semua data provinsi
     *
     * @since 1.0.0
     * @package Siakad-SD-Negeri
     * @author Dasa Kreativa Studio
     */
    function dataProvinsi(Request $request)
    {
        $response = Http::withOptions(['verify' => false])
                    ->get(asset('json/propinsi.json'));

        if($request->get('term')) {
            $query = Str::upper(urldecode($request->get('term')));
            $pattern = '/' . $query . '/i';

            foreach ($response->json() as $key => $value) {
                if(preg_match($pattern, $value['nama'])) {
                    $result[] = $value;
                }
            }

            // Return Value
            return response()->json([
                "total_count" => count($result),
                "incomplete_results" => false,
                "items" => $result,
            ]);
        } else {
            // Return Value
            return response()->json([
                "total_count" => count($response->json()),
                "incomplete_results" => false,
                "items" => $response->json(),
            ]);
        }
    }

    /**
     * Return Response Data Kabupaten
     * Mengambil data semua data kabupaten
     *
     * @since 1.0.0
     * @package Siakad-SD-Negeri
     * @author Dasa Kreativa Studio
     */
    function dataKabupaten($provinsi, Request $request)
    {
        $response = Http::withOptions(['verify' => false])
                    ->get(asset("json/kabupaten/{$provinsi}.json"));
        if($request->get('term')) {
            $query = Str::upper(urldecode($request->get('term')));
            $pattern = '/' . $query . '/i';

            foreach ($response->json() as $key => $value) {
                if(preg_match($pattern, $value['nama'])) {
                    $result[] = $value;
                }
            }

            // Return Value
            return response()->json([
                "total_count" => count($result),
                "incomplete_results" => false,
                "items" => $result,
            ]);
        } else {
            // Return Value
            return response()->json([
                "total_count" => count($response->json()),
                "incomplete_results" => false,
                "items" => $response->json(),
            ]);
        }
    }

    /**
     * Return Response Data Kecamatan
     * Mengambil data semua data kecamatan
     *
     * @since 1.0.0
     * @package Siakad-SD-Negeri
     * @author Dasa Kreativa Studio
     */
    function dataKecamatan($kabupaten, Request $request)
    {
        $response = Http::withOptions(['verify' => false])
                    ->get(asset("json/kecamatan/{$kabupaten}.json"));
        if($request->get('term')) {
            $query = Str::upper(urldecode($request->get('term')));
            $pattern = '/' . $query . '/i';

            foreach ($response->json() as $key => $value) {
                if(preg_match($pattern, $value['nama'])) {
                    $result[] = $value;
                }
            }

            // Return Value
            return response()->json([
                "total_count" => count($result),
                "incomplete_results" => false,
                "items" => $result,
            ]);
        } else {
            // Return Value
            return response()->json([
                "total_count" => count($response->json()),
                "incomplete_results" => false,
                "items" => $response->json(),
            ]);
        }
    }

    /**
     * Return Response Data Kelurahan
     * Mengambil data semua data kelurahan
     *
     * @since 1.0.0
     * @package Siakad-SD-Negeri
     * @author Dasa Kreativa Studio
     */
    function dataKelurahan($kecamatan, Request $request)
    {
        $response = Http::withOptions(['verify' => false])
                    ->get(asset("json/kelurahan/{$kecamatan}.json"));
        if($request->get('term')) {
            $query = Str::upper(urldecode($request->get('term')));
            $pattern = '/' . $query . '/i';

            foreach ($response->json() as $key => $value) {
                if(preg_match($pattern, $value['nama'])) {
                    $result[] = $value;
                }
            }

            // Return Value
            return response()->json([
                "total_count" => count($result),
                "incomplete_results" => false,
                "items" => $result,
            ]);
        } else {
            // Return Value
            return response()->json([
                "total_count" => count($response->json()),
                "incomplete_results" => false,
                "items" => $response->json(),
            ]);
        }
    }
}
