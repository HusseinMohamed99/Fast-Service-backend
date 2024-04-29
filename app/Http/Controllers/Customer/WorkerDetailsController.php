<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkerDetailsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class WorkerDetailsController extends Controller
{
    public function __invoke(WorkerDetailsRequest $request)
    {
        $validatedData = $request->validated();

        $workerId = $validatedData['id'];
        // Check if the worker ID is provided
        if (!$workerId) {
            return $this->handleResponse(status: false, message: 'Worker ID not provided', code: 400);
        }

        // Retrieve worker details from the database
        $worker = User::with('informationWorker')->find($workerId);

        // Check if the worker exists
        if (!$worker) {
            return $this->handleResponse(status: false, message: 'Worker not found', code: 404);
        }


        // Get the URL of the worker's profile image from the 'user_profile_image' collection


        $profileImage = $worker->getFirstMedia('user_profile_image');

        if ($profileImage) {
            $profileImageUrl = $profileImage->getUrl();
        } else {
            $profileImageUrl = asset('Default/profile.jpeg');
        }

        // Format the worker data
        $formattedWorker = [
            'worker_id' => $worker->id,
            'name' => $worker->name,
            'role' => $worker->role,
            'type' => $worker->type,
            'phone_number' => $worker->phone_number,
            'whatsapp_number' => $worker->whatsapp_number,
            'profile_image_url' => $profileImageUrl,
            'address' => $worker->informationWorker->address,
            'details' => $worker->informationWorker->details,
            'price_from' => $worker->informationWorker->price_from,
            'price_to' => $worker->informationWorker->price_to,
            'working_hours_from' => $worker->informationWorker->working_hours_from,
            'price_from' => $worker->informationWorker->price_from,
            'working_hours_to' => $worker->informationWorker->working_hours_to,
        ];

        return $this->handleResponse(status: true, data: $formattedWorker);
    }

    }


