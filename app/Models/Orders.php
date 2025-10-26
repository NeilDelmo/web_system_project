<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'customer_id',
        'order_date',
        'order_type',
        'status',
        'total_amount',
        'handled_by'
    ];

    protected $casts = [
        'order_id' => 'integer',
        'customer_id' => 'integer',
        'order_date' => 'datetime',
        'status' => 'string',
        'total_amount' => 'decimal:2'
    ];
}
