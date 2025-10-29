<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredients extends Model
{
    use HasFactory;

    protected $table = 'ingredients';
    protected $primaryKey = 'ingredient_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'category',
        'unit',
        'quantity',
        'reorder_level',
        'storage_location',
        'status'
    ];
    protected $casts = [
        'ingredient_id' => 'integer',
        'name' => 'string',
        'category' => 'string',
        'unit' => 'string',
        'quantity' => 'decimal:2',
        'reorder_level' => 'decimal:2',
        'storage_location' => 'string',
        'status' => 'string'
    ];
}
