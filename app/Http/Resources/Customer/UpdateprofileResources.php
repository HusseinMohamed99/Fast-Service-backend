<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdateprofileResources extends JsonResource
{
    public function toArray($request): array
    {
        $defaultImage = asset('Default/profile.jpeg');
        return [
            "name"  => $this->whenHas('name'),

            'image'=>$this->getFirstMediaUrl('user_profile_image')?:$defaultImage,

            'phone_number' => $this->whenHas('phone_number'),
            'whatsapp_number' => $this->whenHas('whatsapp_number'),

        ];
    }
}
