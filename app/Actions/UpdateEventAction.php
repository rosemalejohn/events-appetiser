<?php namespace App\Actions;

use App\Models\Event;

class UpdateEventAction
{

    public function execute(Event $event, $data)
    {
        $event->title = $data->title;
        $event->date_from = $data->date_from;
        $event->date_to = $data->date_to;
        $event->save();

        $event->eventDates()->delete();

        $dates = array_map(function($date) {
            return compact('date');
        }, $data->dates);

        $event->eventDates()->createMany($dates);

        return $event;
    }
}