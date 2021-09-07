<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Disable unselected columns.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Mengambil Data tiket yang tertaut di event ini
     *
     * @package Ticket-Online
     * @since 1.0.0
     * @author Dasa Kreativa Studio
     */
    public function ticketsEvent()
    {
        return $this->belongsTo(Ticket::class, 'event_id', 'event_id');
    }

    /**
     * Mengambil Data user dari relasi hasOne (one to one)
     *
     * @package Ticket-Online
     * @since 1.0.0
     * @author Dasa Kreativa Studio
     */
    public function getUsers()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    /**
     * Mengambil Data kategori dari relasi hasOne (one to one)
     *
     * @package Ticket-Online
     * @since 1.0.0
     * @author Dasa Kreativa Studio
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, 'slug', 'category');
    }
}
