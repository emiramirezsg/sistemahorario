<?php
namespace App\Http\Controllers;

use App\Models\Paralelo;
use App\Models\Curso;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index()
    {
        $paralelos = Paralelo::with('curso')->get();
        return view('paralelos.index', compact('paralelos'));
    }

    public function create()
    {
        $cursos = Curso::all();
        return view('paralelos.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad_est' => 'required|integer',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Paralelo::create($validated);

        return redirect()->route('cursos.index');
    }

    public function show(Paralelo $paralelo)
    {
        return view('paralelos.show', compact('paralelo'));
    }

    public function edit(Paralelo $paralelo)
    {
        $cursos = Curso::all();
        return view('cursos.edit', compact('paralelo', 'cursos'));
    }

    public function update(Request $request, Paralelo $paralelo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad_est' => 'required|integer',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $paralelo->update($validated);

        return redirect()->route('cursos.index');
    }

    public function destroy(Paralelo $paralelo)
    {
        $paralelo->delete();

        return redirect()->route('cursos.index');
    }
}
