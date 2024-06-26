<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;


class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable , InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'email_verified_at',
        'role',
        'type',
        'phone_number',
        'whatsapp_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

        static::deleting(function ($user) {
            if ($user->informationWorker && !is_null($user->informationWorker->worker_id)) {
                $user->informationWorker->delete();
            }
        });
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user_profile_image');
    }
    public function informationWorker()
    {
        return $this->hasOne(InformationWorker::class, 'worker_id');
    }

    public function savedWorkers()
    {
        return $this->belongsToMany(User::class, 'saved_workers', 'user_id', 'worker_id');
    }


}
