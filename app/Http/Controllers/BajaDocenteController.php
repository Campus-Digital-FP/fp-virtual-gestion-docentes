<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tutor;        
use App\Models\Coordinador;  
use App\Models\Docencia;

class BajaDocenteController extends Controller
{
    public function index()
    {
        $centro = Auth::user()->centro;
        $idCentro = $centro->id_centro;

        $docentes = Docente::whereIn('dni', function ($query) use ($idCentro) {
            $query->select('dni')
                ->from('centro_docente')
                ->where('id_centro', $idCentro);
        })->get();

        foreach ($docentes as $docente) {
            $dni = $docente->dni;
            $docente->es_tutor = Tutor::where('dni', $dni)->where('id_centro', $idCentro)->exists();
            $docente->es_coordinador = Coordinador::where('dni', $dni)->where('id_centro', $idCentro)->exists();
            $docente->tiene_docencia = Docencia::where('dni', $dni)->where('id_centro', $idCentro)->exists();
        }

        return view('baja_docente', compact('docentes'));
    }

    public function destroy($dni)
    {
        $centro = Auth::user()->centro;
        $idCentro = $centro->id_centro;

        DB::beginTransaction();

        try {
            // Eliminar asignaciones
            Tutor::where('dni', $dni)->where('id_centro', $idCentro)->delete();
            Coordinador::where('dni', $dni)->where('id_centro', $idCentro)->delete();
            Docencia::where('dni', $dni)->where('id_centro', $idCentro)->delete();

            // Eliminar relación centro_docente
            DB::table('centro_docente')
                ->where('dni', $dni)
                ->where('id_centro', $idCentro)
                ->delete();

            DB::commit();

            return redirect()->route('docentes.index')->with('success', 'Docente dado de baja correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('docentes.index')->withErrors(['error' => 'Error al dar de baja al docente.']);
        }
    }


}
