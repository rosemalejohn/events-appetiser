<?php namespace App\Actions;

use App\Models\Event;

class CreateEventAction
{
    public function execute($data)
    {
        $event = Event::create([
            'title' => $data->title,
            'date_from' => $data->date_from,
            'date_to' => $data->date_to,
        ]);

        $dates = array_map(function($date) {
            return compact('date');
        }, $data->dates);

        $event->eventDates()->createMany($dates);
    }
}