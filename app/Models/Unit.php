<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Unit extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'fantasy_name',
        'social_reason',
        'cnpj',
        'flag_id'
    ];

    public function flag()
    {
        return $this->belongsTo(Flag::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
