<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Event;
use App\Models\Helper;
use App\Models\User;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    /**
     * Main Index
     * Menampilkan semua data event
     *
     * @package Ticket-Online
     * @since 1.0.0
     * @author Dasa Kreativa Studio
     */
    function main(Categories $category, Helper $helper, Carbon $carbon, Wilayah $wilayah, Event $events)
    {
        $data['events']     = $events->where('status', 'open')->select(['event_name', 'event_id', 'provinsi', 'kabupaten', 'event_banner', 'event_type', 'start_time', 'end_time', 'id_user', 'event_do'])->paginate(20);
        $data['title']      = 'Jelajahi Event &mdash; ' . config('app.name');

        $data['carbon']     = $carbon;
        $data['wilayah']    = $wilayah;
        $data['helper']     = $helper;
        $data['category']   = $category->select(['cat_name', 'slug']);

        return view('discover-main', $data);
    }

    function kategori(string $slug = '')
    {
        $categories = new Categories();
        $helper = new Helper();
        $wilayah = new Wilayah();
        $carbon = new Carbon();

        $query = $categories->select(['slug', 'cat_name'])->where('slug', $slug);
        if($query->count() > 0)
        {
            $data['query']      = $query->first();
            $data['events']     = $query->first()
                                  ->getEventbyCategory()
                                  ->where('status', 'open')
                                  ->select(['event_name', 'event_id', 'provinsi', 'kabupaten', 'event_banner', 'event_type', 'start_time', 'end_time', 'id_user', 'event_do'])
                                  ->paginate(20);

            $data['title']      = 'Kategori "' . $query->first()->cat_name . '" &mdash; ' . config('app.name');

            $data['carbon']     = $carbon;
            $data['wilayah']    = $wilayah;
            $data['helper']     = $helper;
            $data['category']   = $categories->select(['cat_name', 'slug']);

            return view('discover-categories', $data);
        } else {
            return redirect()->route('home');
        }
    }

    function organization(string $username = '')
    {
        $categories = new Categories();
        $helper     = new Helper();
        $wilayah    = new Wilayah();
        $carbon     = new Carbon();
        $user       = new User();

        $query = $user->select(['institution', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'alamat', 'created_at', 'username'])->where('username', $username);
        if($query->count() > 0)
        {
            $data['query']      = $query->first();
            $data['events']     = $query->first()->getEvents()->select(['event_name', 'event_do', 'event_id', 'provinsi', 'kabupaten', 'event_banner', 'event_type', 'id_user', 'start_time', 'end_time'])->paginate(20);

            $data['title']      = 'Instansi "' . $query->first()->institution . '" &mdash; ' . config('app.name');

            $data['carbon']     = $carbon;
            $data['wilayah']    = $wilayah;
            $data['helper']     = $helper;
            $data['category']   = $categories->select(['cat_name', 'slug']);

            return view('discover-organization', $data);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Show Item
     * Menampilkan satu data event
     *
     * @package Ticket-Online
     * @since 1.0.0
     * @author Dasa Kreativa Studio
     */
    function show(Event $event, $id, Helper $helper, Carbon $carbon, Wilayah $wilayah)
    {
        $query = $event->where('event_id', $id);
        if($query->count() > 0) {
            $data['event'] = $query->select(['event_name', 'category', 'status', 'event_desc_short', 'event_id', 'provinsi', 'event_do', 'start_date', 'end_date', 'kecamatan', 'kelurahan', 'alamat', 'kabupaten', 'thumbnail', 'event_banner', 'event_type', 'start_time', 'end_time', 'event_tos', 'event_desc', 'thumbnail', 'id_user'])->first();
            $data['author'] = $data['event']->getUsers()->first();
            $data['title'] = "{$query->select(['event_name'])->first()->event_name} &mdash; " . config('app.name');

            $data['carbon']     = $carbon;
            $data['wilayah']    = $wilayah;
            $data['helper']     = $helper;

            return view('discover-show', $data);
        } else {
            return redirect()->route('home');
        }
    }

    function search(Request $request, Event $event)
    {
        if($request->ajax())
        {
            if($request->input('search'))
            {
                $search = str_replace(['<script>', '</script>'], ['&lt;script&gt;', '&lt;/script&gt;'], $request->input('search'));
                $query  = $event->select(['event_name', 'event_id', 'provinsi', 'kabupaten', 'event_banner', 'event_type', 'start_time', 'end_time', 'start_date', 'end_date']);
                $query  = $query->where('event_name', 'LIKE', "%{$search}%");

                if($query->count() > 0) :
                    foreach ($query->get() as $value) {
                        $queries[] = [
                            'events' => $value,
                            'price' => $value->ticketsEvent()->select(['price'])->first()
                        ];
                    }
                else :
                    (array) $queries = [];
                endif;

                return response()->json([
                    'status' => 'success',
                    'count'  => $query->count(),
                    'params' => $request->all(),
                    'data'   => $queries,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'count'  => 0,
                    'params' => $request->all(),
                    'data'   => [],
                ], 200);
            }
        } else {
            return abort(401, 'Access denied.');
        }
    }
}
