<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use App\Models\Ciclo;
use App\Models\Tutor; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstablecerCoordinadorController extends Controller
{
    public function index(Request $request)
    {
        

        $user = Auth::user();
        $centro = $user->centro;
    
        // Obtener el campo de ordenación (por defecto 'nombre')
        $sortField = $request->input('sort', 'nombre');

        // Se ordena dependiendo el campo que hayamos seleccionado
        $coordinadores = Coordinador::with('ciclo', 'centro', 'docente')
        ->where('id_centro', $centro->id_centro)
        ->get();
    
        $coordinadores = match ($sortField) {
            'ciclo' => $coordinadores->sortBy(fn($c) => strtolower($c->ciclo->nombre)),
            'nombre' => $coordinadores->sortBy(fn($c) => [strtolower($c->docente->nombre), strtolower($c->docente->apellido)]),
            'apellido' => $coordinadores->sortBy(fn($c) => [strtolower($c->docente->apellido), strtolower($c->docente->nombre)]),
            default => $coordinadores->sortBy(fn($c) => strtolower($c->docente->$sortField)),
        };

        // Ciclos del centro
        $ciclos = $centro->ciclos;
        
        //
        $docentes = \App\Models\Docente::whereIn('dni', function ($query) use ($centro) {
            $query->select('dni')
                  ->from('centro_docente')
                  ->where('id_centro', $centro->id_centro);
        })->get(['dni', 'nombre', 'apellido']);
        

        
        return view('establecer_coordinador', compact('ciclos', 'coordinadores', 'docentes', 'sortField'));

    }

    public function store(Request $request)
    {  
        $request->validate([
            'id_ciclo' => 'required|exists:ciclos,id_ciclo', 
            'dni' => 'required|string',  
            'es_tutor' => 'nullable|boolean',  
        ]);

        $idCentro = Auth::user()->id_centro;

        $existe = Coordinador::where('id_centro', $idCentro)
            ->where('id_ciclo', $request->id_ciclo)
            ->where('dni', $request->dni)
            ->exists();

        if ($existe) {
            return redirect()->back()->withErrors(['dni' => 'Este coordinador ya está asignado a ese ciclo.']);
        }

        // Si también es tutor, se guarda en la tabla de tutores
        if ($request->es_tutor == 1) {
            $tutor = Tutor::firstOrCreate([
                'id_centro' => $idCentro,
                'id_ciclo' => $request->id_ciclo,
                'dni' => $request->dni,
            ]);

            // Si NO fue recién creado, significa que ya existía
            if (!$tutor->wasRecentlyCreated) {
                return redirect()->back()->withErrors(['ciclo' => 'Este docente ya es tutor de ese ciclo.']);
            }
        }

        //Se crea el coordinador
        Coordinador::create([
            'id_centro' => $idCentro,
            'id_ciclo' => $request->id_ciclo,            
            'dni' => $request->dni,
        ]);

        return redirect()->route('establecer_coordinador.index')->with('success', 'Coordinador añadido correctamente.');
    }


    public function destroy($id)
    {
        $coordinador = Coordinador::findOrFail($id);
        $coordinador->delete();

        return redirect()->back()->with('success', 'Coordinador eliminado correctamente.');
    }

}
