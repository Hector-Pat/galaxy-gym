<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos asignables en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'active',
        // Membresía asignada
        'membership_id',
        'membership_start_date',
        'membership_end_date',
    ];

    /**
     * Atributos ocultos al serializar.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de atributos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Un usuario pertenece a un rol.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Membresía asignada al usuario.
     */
    public function membership()
    {
        return $this->belongsTo(\App\Models\Membership::class);
    }



    /**
     * Indica si la membresía del usuario está activa.
     */
    public function getMembershipIsActiveAttribute(): bool
    {
        if (!$this->membership_end_date) {
            return false;
        }

        return Carbon::now()->lte($this->membership_end_date);
    }


}
