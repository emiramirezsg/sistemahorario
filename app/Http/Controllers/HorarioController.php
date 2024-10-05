<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\Curso;
use App\Models\Materia;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::all(); // Obtener todos los horarios

        // Si necesitas pasar el usuario, por ejemplo, el usuario autenticado
        $user = auth()->user(); // Obtener el usuario autenticado

        return view('horarios.index', compact('horarios', 'user'));
    }
    public function generateSchedules(Request $request)
    {
        // Aquí puedes implementar la lógica para generar horarios.
        // Por ejemplo, podrías insertar datos en la tabla `horarios`.

        // Obtener todos los docentes, cursos y materias
        $docentes = Docente::all();
        $cursos = Curso::all();
        $materias = Materia::all();

        // Ejemplo de lógica simple para generar horarios
        foreach ($docentes as $docente) {
            foreach ($cursos as $curso) {
                foreach ($materias as $materia) {
                    Horario::create([
                        'docente_id' => $docente->id,
                        'curso_id' => $curso->id,
                        'materia_id' => $materia->id,
                        'dia' => 'Lunes', // Ejemplo, puedes usar una lógica más compleja
                        'hora_inicio' => '08:00:00',
                        'hora_fin' => '10:00:00',
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Horarios generados correctamente']);
    }
    public function showHorarios()
    {
        $user = Auth::user();
        $horarios = $user->horarios()->with('materia', 'aula')->get(); // Cargar horarios con materias y aulas

        dd($horarios);

        return view('docentevista.index');
    }
}
