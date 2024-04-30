<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worker_id'

    ];
        // Define the relationship with the User model (user who saves the workers)
        public function userFrom()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        // Define the relationship with the User model (user for whom workers are saved)
        public function userTo()
        {
            return $this->belongsTo(User::class, 'worker_id');
        }

        // Define the relationship with the Worker model
        public function users()
        {
            return $this->belongsTo(User::class);
        }

}
