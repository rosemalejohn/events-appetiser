<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventDate;
use App\Http\Resources\EventDateCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class EventDateController extends Controller
{
    public function index()
    {
        $eventDates = QueryBuilder::for(EventDate::class)
            ->allowedFilters([
                'date',
                Filter::scope('date_between'),
            ])
            ->allowedIncludes('event')
            ->get();

        return new EventDateCollection($eventDates);
    }
}
