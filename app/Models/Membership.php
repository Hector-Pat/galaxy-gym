<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'active',
    ];

    /**
     * Usuarios que tienen esta membresía.
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }

}
