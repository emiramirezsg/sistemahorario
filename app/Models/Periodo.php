<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = ['hora_inicio', 'hora_fin', 'dia'];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
