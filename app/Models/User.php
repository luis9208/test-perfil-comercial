<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombres',
        'apellido_1',
        'apellido_2',
        'cedula',
        'fecha_nacimiento',
        'genero',
        'fecha_ingreso',
        'numero_empleado',
        'cargo',
        'jefe',
        'zona',
        'municipio',
        'departamento',
        'ventas',
        'email',
        'imagen',
        'password',
        'celular',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // /**
    //  * The attributes that should be mutated to dates.
    //  *
    //  * @var array
    //  */
    // protected $dates = [
    //     'fecha_ingreso', 'fecha_nacimiento',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_ingreso' => 'datetime:Y-m-d',
        'fecha_nacimiento' => 'datetime:Y-m-d',
    ];


    public function scopeSubordinates($query, $id_jefe, $cargo){
        return $query->where('jefe', $id_jefe)
        ->where('cargo','<>', $cargo)
        ->get();
    }
}
