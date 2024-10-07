<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Categoria;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('categoria')->get();
        $docentes = Docente::with('materias')->get();
        return view('docentes.index', compact('docentes', 'materias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $materias = Materia::all();
        return view('docentes.create', compact('categorias', 'materias'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validar la solicitud
        $validated = $request->validate([
            'nombre' => 'required|',
            'apellido' => 'required|',
            'email' => 'required|email|unique:users,email',
            'categoria_id' => 'required|exists:categorias,id',
            'password' => 'required|confirmed',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_docente' => true, // Asegúrate de marcar al usuario como docente
        ]);
        $user->role = 'docente';
        $user->save();

        // Crear el docente
        Docente::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'categoria_id' => $validated['categoria_id'],
            'user_id' => $user->id, 
        ]);

        return redirect()->route('docentes.index')->with('success', 'Docente creado con éxito.');
    }

    public function show(Docente $docente)
    {
        $docente = Docente::with('materias')->find($id);
        if (!$docente) {
            abort(404, 'Docente no encontrado');
        }
        $materias = $docente->materias;

        return view('docente.show', compact('docente', 'materias'));
    }

    public function edit(Docente $docente)
    {
        $categorias = Categoria::all();
        $materias = Materia::all();
        return view('docentes.edit', compact('docente', 'categorias', 'materias'));
    }

    public function update(Request $request, Docente $docente)
    {
        // Validar la solicitud
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $docente->user_id,
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Actualizar el usuario
        $user = User::findOrFail($docente->user_id);
        $user->update([
            'name' => $validated['nombre'],
            'email' => $validated['email'],
        ]);

        // Actualizar el docente
        $docente->update([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'categoria_id' => $validated['categoria_id'],
        ]);

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado con éxito.');
    }

    public function destroy(Docente $docente)
    {
        // Eliminar el usuario asociado
        $user = User::findOrFail($docente->user_id);
        $user->delete();

        // Eliminar el docente
        $docente->delete();

        return redirect()->route('docentes.index')->with('success', 'Docente eliminado con éxito.');
    }
    public function horarios()
    {
        $user = Auth::user();
        $docente = Docente::where('user_id', $user->id)->first();
        
        if (!$docente) {
            return redirect()->route('home')->with('error', 'No se encontró el docente asociado.');
        }


        return view('docentevista.index');
    }
}
