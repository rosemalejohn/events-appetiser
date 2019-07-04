<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'date_from',
        'date_to'
    ];

    public function eventDates()
    {
        return $this->hasMany(EventDate::class);
    }
}
