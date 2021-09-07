<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTransaction extends Model
{
    use HasFactory;

    /**
     * Disable unselected columns.
     *
     * @var array
     */
    protected $guarded = [];

    function getTicket() {
        return $this->hasOne(Ticket::class, 'id_ticket', 'ticket_id');
    }
}
