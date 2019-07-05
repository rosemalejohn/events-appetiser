<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Actions\CreateEventAction;
use App\Actions\UpdateEventAction;
use App\Http\Resources\Event as EventResource;
use App\Models\Event;

class EventController extends Controller
{

    public function store(EventRequest $request)
    {
        $event = (new CreateEventAction())->execute($request);

        return new EventResource($event);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event = (new UpdateEventAction($event))->execute($event, $request);

        return new EventResource($event);
    }
}
