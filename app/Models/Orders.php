<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Orders extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $table = 'orders';

    protected $fillable = [
        'order_type',
        'customer_name',
        'customer_phone',
        'total_amount',
        'status',
        'notes',
        'staff_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_type' => 'string',
        'status' => 'string',
    ];

    /**
     * Get the staff member who handled this order
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
