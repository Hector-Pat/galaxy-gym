<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discount_type',
        'discount_value',
        'membership_id',
        'starts_at',
        'ends_at',
        'active',
    ];

    /**
     * Una promoción pertenece a una membresía.
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
