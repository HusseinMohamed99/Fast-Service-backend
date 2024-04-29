<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'address',
        'details',
        'price_from',
        'price_to',
        'working_hours_from',
        'working_hours_to',

    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

}
