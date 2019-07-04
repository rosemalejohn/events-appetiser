<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Actions\CreateEventAction;
use App\Http\Resources\EventDate as EventDateResource;

class EventController extends Controller
{

    public function store(CreateEventRequest $request)
    {
        $event = new CreateEventAction();
        $event = $event->execute($request);

        // return new EventDateResource($event);
    }
}
