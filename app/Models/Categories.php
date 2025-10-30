<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Categories extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $table = 'categories';


    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }


}
