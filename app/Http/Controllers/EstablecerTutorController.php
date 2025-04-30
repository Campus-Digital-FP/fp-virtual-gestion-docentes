<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use App\Models\Ciclo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstablecerTutorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $centro = $user->centro;

        // Trae los tutores del centro con relaciones
        $tutores = Tutor::with('ciclo', 'docente')
            ->where('id_centro', $centro->id_centro)
            ->get()
            ->sortBy(function ($tutor) {
                return strtolower($tutor->docente->nombre . ' ' . $tutor->docente->apellidos);
            });

        $ciclos = $centro->ciclos;
        $docentes = \App\Models\Docente::whereIn('dni', function ($query) use ($centro) {
            $query->select('dni')
                  ->from('centro_docente')
                  ->where('id_centro', $centro->id_centro);
        })->get(['dni', 'nombre', 'apellido']);

        return view('establecer_tutor', compact('ciclos', 'tutores', 'docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ciclo' => 'required|exists:ciclos,id_ciclo',
            'dni' => 'required|string',
        ]);

        $idCentro = Auth::user()->id_centro;

        $existe = Tutor::where('id_centro', $idCentro)
            ->where('id_ciclo', $request->id_ciclo)
            ->where('dni', $request->dni)
            ->exists();

        if ($existe) {
            return redirect()->back()->withErrors(['dni' => 'Este tutor ya está asignado a ese ciclo.']);
        }

        Tutor::create([
            'id_centro' => $idCentro,
            'id_ciclo' => $request->id_ciclo,
            'dni' => $request->dni,
        ]);

        return redirect()->route('establecer_tutor.index')->with('success', 'Tutor añadido correctamente.');
    }

    public function destroy($id)
    {
        $tutor = Tutor::findOrFail($id);
        $tutor->delete();

        return redirect()->back()->with('success', 'Tutor eliminado correctamente.');
    }
}
