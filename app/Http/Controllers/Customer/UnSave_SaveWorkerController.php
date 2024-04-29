<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SavedWorker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnSave_SaveWorkerController extends Controller
{
    public function __invoke(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();
        $same_user = Auth::id();

        // Check if worker ID is provided
        $workerId = $request->input('id');
        if (!$workerId) {
            return $this->handleResponse(message: 'Worker ID is required', code: 400, status: false);
        }

        // Check if the worker exists
        $workerExists = User::where('id', $workerId)->exists();
        if (!$workerExists) {
            return $this->handleResponse(message: 'Worker Not found', code: 404, status: false);
        }

        if ($same_user == $workerId) {
            return $this->handleResponse(message: "Can't Save Your Self", code: 404, status: false);
        }

        // Check if the worker is already saved for the user
        $savedWorker = SavedWorker::where('user_id', $user->id)
                                  ->where('worker_id', $workerId)
                                  ->exists();

        // Save or unsave the worker based on its existence
        if ($savedWorker) {
            SavedWorker::where('user_id', $user->id)
                       ->where('worker_id', $workerId)
                       ->delete();
            $message = 'Worker removed successfully';
        } else {
            SavedWorker::create([
                'user_id' => $user->id,
                'worker_id' => $workerId,
            ]);
            $message = 'Worker saved successfully';
        }

        return $this->handleResponse(message: $message);
    }

}
