<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    /**
     * Disable unselected columns.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Ambil Data Event
     * Mengambil data berdasarkan slug kategori
     *
     * @package Ticket-Online
     * @since 1.0.0
     * @author Dasa Kreativa Studio
     */
    public function getEvent($category_name = null, $limit = 0, $array = [])
    {
        $event = new Event();

        if($limit > 0) :
            if(empty($array)) :
                return $event->where([
                    'category' => $category_name,
                    'status' => 'open'
                ])->limit(12)->get();
            else :
                return $event->select($array)->where([
                    'category' => $category_name,
                    'status' => 'open'
                ])->limit(12)->get();
            endif;
        else :
            if(empty($array)) :
                return $event->where([
                    'category' => $category_name,
                    'status' => 'open'
                ])->get();
            else :
                return $event->select( $array)->where([
                    'category' => $category_name,
                    'status' => 'open'
                ])->get();
            endif;
        endif;

        unset($array, $limit, $cat);
    }

    /**
     * Get Event Based Category
     * Mengambil data event berdasarkan kategori
     */
    function getEventbyCategory() {
        $event = new Event();
        return $this->belongsTo($event, 'slug', 'category')->where([
            'status' => 'open'
        ]);
    }

    function getAllEvent() {
        $event = new Event();
        return $this->belongsTo($event, 'slug', 'category');
    }
}
