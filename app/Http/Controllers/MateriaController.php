<?php
namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Curso;
use App\Models\Docente;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all(); 
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'nombre' => 'required|string|max:255',
            'horas_semana' => 'required|integer|min:1', // Asegúrate de que se proporcione y sea mayor que 0
        ]);
        
        Materia::create([
            'nombre' => $request->nombre,
            'horas_semana' => $request->horas_semana, // Incluye esto
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia creada con éxito.');
    }

    public function show(Materia $materia)
    {
        $materia->load('docente'); // Usa `load` para evitar consultas adicionales
        $docentes = Docente::all(); // Si necesitas mostrar todos los docentes

        return view('materias.show', compact('materia', 'docentes'));
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'horas_semana' => 'required',
        ]);

        $materia->update($validated);

        return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada exitosamente.');
    }
}
