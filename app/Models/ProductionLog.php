<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Audit;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductionLog extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'product_id',
        'quantity_produced',
        'ingredients_used',
        'status',
        'notes',
        'produced_by',
        'produced_at',
    ];

    protected $casts = [
        'ingredients_used' => 'array',
        'produced_at' => 'datetime',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function producer()
    {
        return $this->belongsTo(User::class, 'produced_by');
    }
}
