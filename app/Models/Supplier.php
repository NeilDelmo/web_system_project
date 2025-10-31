<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable as AuditableTrait;   

class Supplier extends Model implements AuditableContract
{
    use HasFactory, AuditableTrait;

    protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'status'
    ];
    protected $casts = [
        'name' => 'string',
        'contact_person' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'address' => 'string',
        'status' => 'string'
    ];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(
            Ingredients::class,
            'ingredient_supplier',
            'supplier_id',
            'ingredient_id'
        )->withPivot('unit_price')->withTimestamps();
    }
}
