<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SystemUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'system_users';

    protected $primaryKey = 'user_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'email_verified_at' => 'datetime',
    ];
}
