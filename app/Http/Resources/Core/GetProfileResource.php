<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class GetProfileResource extends JsonResource
{
    public function toArray($request): array
    {

           // Set a default image URL
           $defaultImage = asset('Default/profile.jpeg');

           // Initialize an array to hold user data
           $userData = [
               "id" => $this->whenHas('id'),
               "uuid" => $this->whenHas('uuid'),
               'token' => $this->when($this->createToken('auth_token'), function () {
                   return $this->createToken('auth_token')->plainTextToken;
               }),
               "email" => $this->whenHas('email'),
               "name" => $this->whenHas('name'),
               "role" => $this->whenHas('role'),
               'email_verified' => (bool) $this->email_verified_at,
               "type" => $this->whenHas('type'),
               "phone_number" => $this->whenHas('phone_number'),
               "whatsapp_number" => $this->whenHas('whatsapp_number'),
           ];

           // If the user is a worker, include additional fields
           if ($this->role === 'Worker') {
               $userData = array_merge($userData, [
                   'address' => $this->informationWorker->address ?? null,
                   'details' => $this->informationWorker->details ?? null,
                   'price_from' => $this->informationWorker->price_from ?? null,
                   'price_to' => $this->informationWorker->price_to ?? null,
                   'working_hours_from' => $this->informationWorker->working_hours_from ?? null,
                   'working_hours_to' => $this->informationWorker->working_hours_to ?? null,
               ]);
           }

           // Add the image URL to the user data
           $userData['image'] = (string) $this->getFirstMediaUrl('user_profile_image') ?: $defaultImage;

           return $userData;
       }
   }
