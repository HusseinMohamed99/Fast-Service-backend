<?php

namespace App\Http\Controllers\Worker;


use  App\Http\Requests\WorkerInformationRequest;
use App\Models\InformationWorker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\worker\InformationWorkerResource;
use App\Http\Controllers\Controller;

class InformationWorkerController extends Controller
{
    public function __invoke(WorkerInformationRequest $request)
    {
    $validatedData = $request->validated();
    $user_id = Auth::id();


    $user = InformationWorker::where('worker_id', $user_id)->first();

    if (!$user) {
        $user = new InformationWorker();
        $user->worker_id = $user_id;
    }
    if (Auth::user()->role === 'Worker') {

        $user->address = $validatedData['address'] ?? $user->address;
        $user->details = $validatedData['details'] ?? $user->details;
        $user->price_from = $validatedData['price_from'] ?? $user->price_from;
        $user->price_to = $validatedData['price_to'] ?? $user->price_to;
        $user->working_hours_from = isset($validatedData['working_hours_from']) ? Carbon::parse($validatedData['working_hours_from']) : $user->working_hours_from;
        // Assign working hours to validated data if available, otherwise use existing value
        $user->working_hours_to = isset($validatedData['working_hours_to']) ? Carbon::parse($validatedData['working_hours_to']) : $user->working_hours_to;

        $user->save();

        return $this->handleResponse(message: 'Successfully uploaded data', data: new InformationWorkerResource($user));
    } else {

        return $this->handleResponse(message: 'Unauthorized action', code: 422 , status:false);
    }
    }
}
