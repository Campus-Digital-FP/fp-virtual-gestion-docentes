<?php

namespace App\Http\Controllers;

use App\Models\Docente;  // Asegúrate de importar el modelo Docente
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AltaDocenteController extends Controller
{
    // Método para mostrar el formulario
    public function create()
    {
        return view('alta_docente');
    }

    // Método para almacenar los datos del docente
    public function store(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'dni' => 'required|unique:docentes,dni|max:10', // Validación del DNI
            'email' => 'required|email|unique:docentes,email', // Validación del email
            'nombre' => 'required|string|max:255', // Validación del nombre
            'apellido' => 'required|string|max:255', // Validación del apellido
        ]);

        // Si la validación falla, redirige con los errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Guardar los datos en la base de datos
        Docente::create([
            'dni' => $request->dni,
            'email' => $request->email,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('dashboard')->with('alta_docente_correcto', 'Docente dado de alta correctamente.');
    }
}
