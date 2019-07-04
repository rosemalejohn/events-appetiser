<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    protected $fillable = ['date'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeDateBetween($query, $from, $to)
    {
        return $query->whereBetween('date', [$from, $to]);
    }
}
