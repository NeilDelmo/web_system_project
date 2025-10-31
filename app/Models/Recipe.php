<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Recipe extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $table = 'recipes';
    
    protected $guarded = [];
    
    protected $fillable = [
        'name',
        'product_id',
        'instructions',
        'notes',
        'status',
    ];

    protected $casts = [
        'name' => 'string',
        'product_id' => 'integer',
        'instructions' => 'string',
        'notes' => 'string',
        'status' => 'string',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(
            Ingredients::class,
            'recipe_ingredients',
            'recipe_id',
            'ingredient_id'
        )->withPivot('quantity', 'unit')->withTimestamps();
    }
}
