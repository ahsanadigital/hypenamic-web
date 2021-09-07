<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventTicketController extends Controller
{
    function addTicket(Ticket $tiket, Request $request) {
        $data = $request->except('_token', 'files');
        $data['id_ticket'] = uniqid('tiket-');

        if($request->ajax()) {
            try {
                $data = $tiket->create($data);
                return response()->json([
                    'error' => false,
                    'success' => true,
                    'message' => 'Berhasil menambahkan data tiket kegiatan',
                    'data' => $data,
                ], 200);
            } catch(\Exception $e) {
                return response()->json([
                    'error' => true,
                    'success' => false,
                    'message' => 'Gagal menambahkan data tiket kegiatan',
                    'data' => $e->getMessage(),
                ], 403);
            }
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman tadi!');
        }
    }
    function editTicket(Ticket $tiket, Request $request) {
        $data = $request->except('_token', 'files');
        $data['id_ticket'] = uniqid('tiket-');

        if($request->ajax()) {
            try {
                $data = $tiket->where('id_ticket', $request->id_ticket)->update($data);
                return response()->json([
                    'error' => false,
                    'success' => true,
                    'message' => 'Berhasil mengubah data tiket kegiatan',
                    'data' => $data,
                ], 200);
            } catch(\Exception $e) {
                return response()->json([
                    'error' => true,
                    'success' => false,
                    'message' => 'Gagal mengubah data tiket kegiatan',
                    'data' => $e->getMessage(),
                ], 403);
            }
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman tadi!');
        }
    }

    function details(Request $request, Ticket $tiket) {
        if($request->ajax()) {
            $data = $tiket->where('id_ticket', strip_tags($request->id));
            if($data->count() > 0) {
                return response($data->first());
            } else {
                return response([]);
            }
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman tadi!');
        }
    }
}
