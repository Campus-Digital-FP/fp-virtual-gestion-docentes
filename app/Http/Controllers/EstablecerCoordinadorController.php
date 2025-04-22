<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use App\Models\Ciclo;
use App\Models\Tutor; // Asegúrate de tener el modelo Tutor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstablecerCoordinadorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $centro = $user->centro;
    
        // Cargar los coordinadores junto con los nombres de ciclos y centros ( Ordenador por nombre y apellidos )
        $coordinadores = Coordinador::with('ciclo', 'centro', 'docente')
        ->where('id_centro', $centro->id_centro)
        ->get()
        ->sortBy(function ($coordinador) {
            return strtolower($coordinador->docente->nombre . ' ' . $coordinador->docente->apellidos);
        });

        // Ciclos del centro
        $ciclos = $centro->ciclos;
        
        $dnis = \App\Models\Docente::pluck('dni');
        
        return view('establecer_coordinador', compact('ciclos', 'coordinadores', 'dnis'));

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

        Coordinador::create([
            'id_centro' => $idCentro,
            'id_ciclo' => $request->id_ciclo,            
            'dni' => $request->dni,
        ]);

        // Si también es tutor, se guarda en la tabla de tutores
        if ($request->es_tutor == 1) {
            Tutor::create([
                'id_centro' => $idCentro,
                'id_ciclo' => $request->id_ciclo,
                'dni' => $request->dni,
            ]);
        }

        return redirect()->route('establecer_coordinador.index')->with('success', 'Coordinador añadido correctamente.');
    }


    public function destroy($id)
    {
        $coordinador = Coordinador::findOrFail($id);
        $coordinador->delete();

        return redirect()->back()->with('success', 'Coordinador eliminado correctamente.');
    }

}
