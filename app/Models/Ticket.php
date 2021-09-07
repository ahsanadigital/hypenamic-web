<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * Disable unselected columns.
     *
     * @var array
     */
    protected $guarded = [];

    function getEvent() {
        return $this->hasOne(Event::class, 'event_id', 'event_id');
    }
}
