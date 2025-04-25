<?php

namespace App\Http\Controllers;

use App\Models\Docente;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\CentroDocente;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class AltaDocenteController extends Controller
{
    public function create()
    {
        $centro = Auth::user()->centro;
        return view('alta_docente', compact('centro'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:10',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email',
            'id_centro' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Convertir el DNI a minúsculas
            $dni = strtolower($request->dni);

            // Lógica de creación del docente
            $docente = Docente::where('dni', $dni)->first();

            if (!$docente) {
                $docente = Docente::create([
                    'dni' => $dni,
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                ]);
            }

            // Verificar si ya está asignado al centro
            $yaExiste = CentroDocente::where('dni', $dni)
                ->where('id_centro', $request->id_centro)
                ->exists();

            if ($yaExiste) {
                return redirect()->back()
                    ->withErrors(['dni' => 'Este docente ya está asignado a este centro.'])
                    ->withInput();
            }

            // Si no existe, creamos la relación
            CentroDocente::create([
                'dni' => $dni,
                'id_centro' => $request->id_centro,
                'email' => $request->email,
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('alta_docente_correcto', 'Docente asignado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors(['error' => 'Hubo un error al guardar el docente.'])
                ->withInput();
        }
    }

    

    public function comprobarDocente($dni)
    {
        $docente = \App\Models\Docente::where('dni', $dni)->first();

        if ($docente) {
            return response()->json([
                'existe' => true,
                'nombre' => $docente->nombre,
                'apellido' => $docente->apellido,
            ]);
        }

        return response()->json(['existe' => false]);
    }
}
