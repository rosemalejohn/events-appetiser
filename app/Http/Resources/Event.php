<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EventDate as EventDateResource;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'dates' => EventDateResource::collection($this->whenLoaded('eventDates'))
        ];
    }
}
