<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EconomicGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj'
    ];

    public function flags(): HasMany
    {
        return $this->hasMany(Flag::class);
    }
}
