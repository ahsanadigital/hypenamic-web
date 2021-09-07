<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Disable unselected columns.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the ticket data associated with the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getTicket(): HasOne
    {
        return $this->hasOne(Ticket::class, 'id_ticket', 'ticket_id');
    }
}
