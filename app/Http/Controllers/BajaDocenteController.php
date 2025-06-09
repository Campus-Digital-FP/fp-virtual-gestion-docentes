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
            // Obtener todas las asignaciones antes de borrar
            /*$tutorias = Tutor::where('dni', $dni)->where('id_centro', $idCentro)->get();
            $coordinaciones = Coordinador::where('dni', $dni)->where('id_centro', $idCentro)->get();
            $docencias = Docencia::where('dni', $dni)->where('id_centro', $idCentro)->get();

            // Comando moosh para desmatricular de cohorts tutores
            foreach ($tutorias as $tutor) {
                $cohortName = "tutores_ciclo_{$tutor->id_ciclo}";
                $command = "moosh cohort-unenrol -u " . escapeshellarg($dni) . " " . escapeshellarg($cohortName);
                $this->ejecutarMoosh($command);
            }

            // Comando moosh para desmatricular de cohorts coordinadores
            foreach ($coordinaciones as $coordinador) {
                $cohortName = "coordinadores_ciclo_{$coordinador->id_ciclo}";
                $command = "moosh cohort-unenrol -u " . escapeshellarg($dni) . " " . escapeshellarg($cohortName);
                $this->ejecutarMoosh($command);
            }

            // Comando moosh para desmatricular de cursos (docencia)
            foreach ($docencias as $docencia) {
                $courseName = "modulo_{$docencia->id_modulo}";
                $command = "moosh course-unenrol -u " . escapeshellarg($dni) . " " . escapeshellarg($courseName);
                $this->ejecutarMoosh($command);
            }*/

            // Verificar si el docente pertenece a más centros
            /*$otrosCentros = DB::table('centro_docente')
                ->where('dni', $dni)
                ->exists();

            // Si no pertenece a ningún otro centro, suspender usuario en Moodle
            if (!$otrosCentros) {
                // Comando moosh para suspender cuenta
                $usuarioMoodle = escapeshellarg($dni); 
                $command = "moosh user-suspend " . $usuarioMoodle;
                $this->ejecutarMoosh($command);
            }*/


            // Eliminar asignaciones en la base de datos
            Tutor::where('dni', $dni)->where('id_centro', $idCentro)->delete();
            Coordinador::where('dni', $dni)->where('id_centro', $idCentro)->delete();
            Docencia::where('dni', $dni)->where('id_centro', $idCentro)->delete();

            // Eliminar relación centro-docente
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


    //Ejecuta & Control de errores para comandos moosh
    protected function ejecutarMoosh($command)
    {
        exec($command, $output, $status);
        if ($status !== 0) {
            Log::error("Fallo Moosh: " . implode("\n", $output));
            throw new \Exception("Fallo al ejecutar comando Moosh.");
        }
    }


}
