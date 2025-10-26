<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'category_id';
    public $incrementing = true;
     protected $keyType = 'int';

    protected $fillable = [
        'category_name',
    ];

    protected $casts = [
        'category_id' => 'integer',
    ];


}
