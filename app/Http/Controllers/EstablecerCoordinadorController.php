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

        // Validar si ya existe un coordinador para ese ciclo en ese centro
        $yaExisteCoordinador = Coordinador::where('id_centro', $idCentro)
            ->where('id_ciclo', $request->id_ciclo)
            ->exists();

        if ($yaExisteCoordinador) {
            return redirect()->back()->withErrors(['id_ciclo' => 'Ya existe un coordinador asignado a este ciclo.']);
        }

        // Si también es tutor, comprobar que no exista
        if ($request->es_tutor == 1) {
            
            $yaExisteTutor = Tutor::where('id_centro', $idCentro)
                ->where('id_ciclo', $request->id_ciclo)
                ->exists();

            if ($yaExisteTutor) {
                return redirect()->back()->withErrors(['id_ciclo' => 'Ya existe un tutor asignado a este ciclo.']);
            }

            // Si no existe, lo creamos
            Tutor::create([
                'id_centro' => $idCentro,
                'id_ciclo' => $request->id_ciclo,
                'dni' => $request->dni,
            ]);
        }


        return redirect()->route('establecer_coordinador.index')->with('success', 'Coordinador añadido correctamente.');
    }



    public function destroy($id, Request $request)
    {
        $coordinador = Coordinador::findOrFail($id);
        
        // Verificar si también es tutor en el mismo ciclo
        $esTutor = Tutor::where('id_centro', $coordinador->id_centro)
                    ->where('id_ciclo', $coordinador->id_ciclo)
                    ->where('dni', $coordinador->dni)
                    ->exists();
        
        // Si viene la opción de eliminar tutor y efectivamente es tutor
        if ($request->has('eliminar_tutor') && $esTutor) {
            Tutor::where('id_centro', $coordinador->id_centro)
                ->where('id_ciclo', $coordinador->id_ciclo)
                ->where('dni', $coordinador->dni)
                ->delete();
        }
        
        $coordinador->delete();

        return redirect()->back()->with('success', 'Coordinador eliminado correctamente' . 
            ($request->has('eliminar_tutor') && $esTutor ? ' y también se ha eliminado como tutor' : ''));
    }

}
