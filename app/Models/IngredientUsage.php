<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class IngredientUsage extends Model
{
    use HasFactory;

    protected $table = 'ingredient_usage';
    protected $primaryKey = 'usage_id';

    protected $fillable = [
        'ingredient_id',
        'recorded_by',
        'quantity_used',
        'usage_date'
    ];
    protected $casts = [
        'usage_id' => 'integer',
        'ingredient_id' => 'integer',
        'recorded_by' => 'integer',
        'quantity_used' => 'decimal:2',
        'usage_date' => 'datetime',
    ];
    
}
