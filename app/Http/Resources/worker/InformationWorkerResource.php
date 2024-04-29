<?php

namespace App\Http\Resources\worker;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InformationWorkerResource extends JsonResource
{
    public function toArray($request): array
    {
        $startTime = Carbon::parse($this->working_hours_from);
        $endTime = Carbon::parse($this->working_hours_to);

        $formattedStartTime = $startTime->format('h:i A');
        $formattedEndTimeTime = $endTime->format('h:i A');

        $data= [
            'worker_id'=> $this->whenHas('worker_id'),
            'address'=> $this->whenHas('address'),
            'details'=> $this->whenHas('details'),
            'price_from'=> $this->whenHas('price_from'),
            'price_to'=> $this->whenHas('price_to'),
            'working_hours_from'=> $formattedStartTime,
            'working_hours_to'=> $formattedEndTimeTime,
        ];
        return $data;

    }
}
