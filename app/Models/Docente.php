<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = ['nombre', 'apellido', 'email', 'categoria_id', 'user_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
