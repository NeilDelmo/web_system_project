<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Products extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'description',
        'image',
        'category_id',
        'status',

    ];

    protected $casts = [
        'name' => 'string',
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'description' => 'string',
        'image' => 'string',
        'category_id' => 'integer',
        'status' => 'string',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'product_id');
    }

    public function pricingRules(): HasMany
    {
        return $this->hasMany(PricingRule::class, 'product_id');
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'product_id');
    }

}
