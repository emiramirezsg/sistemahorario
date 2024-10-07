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
        $docentes = Docente::all();
        $docentes = Docente::with('materias')->get();
        $docentes = Docente::with('categoria', 'materias.cursos')->get();
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $materias = Materia::with('cursos')->get();
        return view('docentes.create', compact('categorias', 'materias'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validar la solicitud
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email', // Validación de unicidad del correo
            'password' => 'required|string|min:6|confirmed',
            'categoria_id' => 'required|exists:categorias,id',
            'materia_id' => 'required|exists:materias,id',
        ], [
            'email.unique' => 'El correo ya está en uso. Por favor, usa otro correo electrónico.',
        ]);

        try {
            // Crear el usuario en la tabla `users`
            $user = User::create([
                'name' => $validatedData['nombre'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'is_docente' => 1,
            ]);
            //dd($request->all());
            // Crear el docente en la tabla `docentes`
            $docente = new Docente();
            $docente->nombre = $validatedData['nombre'];
            $docente->apellido = $validatedData['apellido'];
            $docente->email = $validatedData['email'];
            $docente->categoria_id = $validatedData['categoria_id'];
            $docente->user_id = $user->id;
    
            // Guarda el docente en la base de datos
            if ($docente->save()) {
                // Asigna el docente a la materia correspondiente
                //dd($docente);
                $materia = Materia::find($validatedData['materia_id']);
                if ($materia) {
                    $materia->docente_id = $docente->id; // Asignar el ID del docente a la materia
                    $materia->save(); // Guarda los cambios en la materia
                    return redirect()->route('docentes.index')->with('success', 'Docente creado correctamente');
                } else {
                    return back()->with('error', 'La materia no se pudo encontrar.');
                }
            } else {
                $user->delete();
                return back()->with('error', 'Error al guardar el docente');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $docente = Docente::with('materias')->findOrFail($id);
        return view('docentes.show', compact('docente'));
    }


    public function edit(Docente $docente)
    {
        $categorias = Categoria::all(); // Asegúrate de cargar las categorías
        $materias = Materia::all(); // Carga las materias disponibles

        return view('docentes.edit', compact('docente', 'categorias', 'materias'));
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:docentes,email,' . $id, // Permitir el email actual
            'categoria_id' => 'required|exists:categorias,id',
            'materia_id' => 'required|exists:materias,id',
        ]);

        try {
            // Buscar el docente
            $docente = Docente::findOrFail($id);
            $docente->nombre = $validatedData['nombre'];
            $docente->apellido = $validatedData['apellido'];
            $docente->email = $validatedData['email'];
            $docente->categoria_id = $validatedData['categoria_id'];
            
            // Guardar el docente
            $docente->save();

            // Verificar si la materia existe y actualizar el docente_id
            $materia = Materia::find($validatedData['materia_id']);
            if ($materia) {
                $materia->docente_id = $docente->id; // Asignar el ID del docente a la materia
                $materia->save(); // Guarda los cambios en la materia
                return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente y asignado a la materia.');
            } else {
                return back()->with('error', 'La materia no se pudo encontrar.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Buscar el docente
            $docente = Docente::findOrFail($id);
    
            // Eliminar el docente
            $docente->delete();
    
            return redirect()->route('docentes.index')->with('success', 'Docente eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el docente: ' . $e->getMessage());
        }
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
