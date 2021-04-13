<?php

namespace App;

use App\Empresa;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'apellido',
        'empresa_id',
        'email',
        'telefono'
    ];


    public function empresa()
    {
        return $this->hasMany(Empresa::class);
    }
}
