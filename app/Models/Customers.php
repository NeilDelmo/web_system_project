<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $primaryKey = 'customer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'contact_number',
        'email',
        'customer_type'
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'email' => 'string',
        'customer_type' => 'string'
    ];
}
