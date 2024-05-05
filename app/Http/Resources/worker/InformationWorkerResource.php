<?php

namespace App\Http\Resources\worker;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InformationWorkerResource extends JsonResource
{
    public function toArray($request): array
    {



        $formattedStartTime = $this->working_hours_from ? $this->working_hours_from->format('h:i A') : null;
        $formattedEndTimeTime = $this->working_hours_to ? $this->working_hours_to->format('h:i A') : null;


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
