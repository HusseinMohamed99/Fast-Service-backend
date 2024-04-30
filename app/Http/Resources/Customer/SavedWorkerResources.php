<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class SavedWorkerResources extends JsonResource
{
    public function toArray($request): array
    {

        $defaultImage = asset('Default/profile.jpeg');

        $data =  [
            'saved_id' => $this->id,
            'user_id'=>$this-> user_id,
            'worker_id' => $this->worker_id,
            'role' => $this->userTo->type,
            'price_from' => $this->userTo->informationWorker->price_from,
            'price_to' => $this->userTo->informationWorker->price_to,
            'cover_product' => $this->userTo->getFirstMediaUrl('user_profile_image')?: $defaultImage,


        ];

        return $data;

    }
}
