<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;   

class Ingredients extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $table = 'ingredients';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'category',
        'unit',
        'quantity',
        'reorder_level',
        'status'
    ];
    protected $casts = [
        'name' => 'string',
        'category' => 'string',
        'unit' => 'string',
        'quantity' => 'decimal:2',
        'reorder_level' => 'decimal:2',
        'status' => 'string'
    ];

    public function suppliers(): BelongsToMany
{
    return $this->belongsToMany(
        Supplier::class,
        'ingredient_supplier',
        'ingredient_id',
        'supplier_id'
    )->withPivot('unit_price')->withTimestamps();
}

}
