<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Guarded for guard auth
     *
     * @var string
     */
    protected $guard = 'user';

    /**
     * Disable unselected columns.
     *
     * @var array
     */
    protected $guarded = [];

    function getEvents() {
        return $this->belongsTo(Event::class, 'username', 'id_user');
    }
}
