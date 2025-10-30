<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Order items belonging to this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
