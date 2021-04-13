<?php

namespace App;

use App\Empleado;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'nombre',
        'email',
        'logotipo',
        'website'
    ];

    public function empleados()
    {
        return $this->hasOne(Empleado::class);
    }
}
