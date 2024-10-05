<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = ['nombre', 'horas_semana'];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'materia_curso');
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'docente_materia');
    }
}
