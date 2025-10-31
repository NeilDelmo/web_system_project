<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PricingRule extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $table = 'pricing_rules';
    protected $guarded = [];
    protected $fillable = [
        'product_id',
        'min_quantity',
        'discount_type',
        'discount_value',
        'notes',
        'status',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'min_quantity' => 'integer',
        'discount_type' => 'string',
        'discount_value' => 'decimal:2',
        'notes' => 'string',
        'status' => 'string',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
