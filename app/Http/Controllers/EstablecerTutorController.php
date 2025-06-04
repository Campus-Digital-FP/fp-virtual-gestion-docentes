<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use App\Models\Tutor;
use App\Models\Ciclo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class EstablecerTutorController extends Controller
{
        public function index(Request $request)
    {
        $user = Auth::user();
        $centro = $user->centro;

        // Obtener el campo de ordenación (por defecto 'nombre')
        $sortField = $request->input('sort', 'nombre');

        // Obtener tutores con relaciones
        $tutores = Tutor::with('ciclo', 'docente')
            ->where('id_centro', $centro->id_centro)
            ->get();

        // Ordenar según el campo seleccionado
        $tutores = match ($sortField) {
            'ciclo' => $tutores->sortBy(fn($t) => strtolower($t->ciclo->nombre)),
            'nombre' => $tutores->sortBy(fn($t) => [strtolower($t->docente->nombre), strtolower($t->docente->apellido)]),
            'apellido' => $tutores->sortBy(fn($t) => [strtolower($t->docente->apellido), strtolower($t->docente->nombre)]),
            'dni' => $tutores->sortBy(fn($t) => strtolower($t->docente->dni)),
            default => $tutores->sortBy(fn($t) => strtolower($t->docente->$sortField)),
        };

        // Ciclos del centro
        $ciclos = $centro->ciclos;
        
        // Docentes del centro
        $docentes = \App\Models\Docente::whereIn('dni', function ($query) use ($centro) {
            $query->select('dni')
                ->from('centro_docente')
                ->where('id_centro', $centro->id_centro);
        })->get(['dni', 'nombre', 'apellido']);

        return view('establecer_tutor', compact('ciclos', 'tutores', 'docentes', 'sortField'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ciclo' => 'required|exists:ciclos,id_ciclo',
            'dni' => 'required|string',
        ]);

        $idCentro = Auth::user()->id_centro;

        $yaExisteTutor = Tutor::where('id_centro', $idCentro)
            ->where('id_ciclo', $request->id_ciclo)
            ->exists();

        if ($yaExisteTutor) {
            return redirect()->back()->withErrors(['id_ciclo' => 'Ya existe un tutor asignado a este ciclo.']);
        }

        Tutor::create([
            'id_centro' => $idCentro,
            'id_ciclo' => $request->id_ciclo,
            'dni' => $request->dni,
        ]);

        return redirect()->route('establecer_tutor.index')->with('success', 'Tutor añadido correctamente.');
    }

    public function destroy($id, Request $request)
    {
        $tutor = Tutor::findOrFail($id);
        
        // Verificar si también es coordinador en el mismo ciclo
        $esCoordinador = Coordinador::where('id_centro', $tutor->id_centro)
                    ->where('id_ciclo', $tutor->id_ciclo)
                    ->where('dni', $tutor->dni)
                    ->exists();
        
        // Si viene la opción de eliminar coordinador y efectivamente es coordinador
        if ($request->has('eliminar_coordinador') && $esCoordinador) {
            Coordinador::where('id_centro', $tutor->id_centro)
                ->where('id_ciclo', $tutor->id_ciclo)
                ->where('dni', $tutor->dni)
                ->delete();
        }
        
        $tutor->delete();

        return redirect()->back()->with('success', 'Tutor eliminado correctamente' . 
            ($request->has('eliminar_coordinador') && $esCoordinador ? ' y también se ha eliminado como coordinador' : ''));
    }
}
