<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
    public function toArray($request): array
    {
        // Format date_birth using Carbon
        $defaultImage = asset('Default/profile.jpeg');
        return [
            "id"    => $this->whenHas('id'),
            "uuid"  => $this->whenHas('uuid'),
            'token' => $this->createToken('auth_token')->plainTextToken,
            "name"  => $this->whenHas('name'),
            "email" => $this->whenHas('email'),
            "phone_number"  => $this->whenHas('phone_number'),
            "whatsapp_number"  => $this->whenHas('whatsapp_number'),

            'image'=>$this->getFirstMediaUrl('user_profile_image')?:$defaultImage,
            "role" => $this->whenHas('role'),
            "type" => $this->whenHas('type'),

        ];
    }
}
