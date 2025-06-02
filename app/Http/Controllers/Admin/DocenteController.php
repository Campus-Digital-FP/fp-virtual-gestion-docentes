<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\Tutor;
use App\Models\Coordinador;
use App\Models\CentroDocente;
use App\Models\Docencia;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    // Mostrar listado de docentes con filtro y ordenación
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'nombre');
        $allowedSorts = ['nombre', 'apellido', 'dni']; 

        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'nombre';
        }

        $centroDocentes = CentroDocente::with(['docente.tutor', 'docente.coordinador'])
            ->join('docentes as docente', 'centro_docente.dni', '=', 'docente.dni')
            ->select('centro_docente.*')
            ->get()
            // Mapeamos para tener los datos estructurados
            ->map(function ($cd) {
                return (object) [
                    'nombre' => $cd->docente->nombre,
                    'apellido' => $cd->docente->apellido,
                    'dni' => $cd->dni,
                    'es_tutor' => $cd->docente->tutor !== null,
                    'es_coordinador' => $cd->docente->coordinador !== null,
                ];
            })
            // Eliminamos duplicados por dni
            ->unique('dni')
            ->values(); 

        // Ordenamos según el campo solicitado
        $centroDocentes = match ($sortField) {
            'nombre' => $centroDocentes->sortBy(fn($d) => [strtolower($d->nombre), strtolower($d->apellido)]),
            'apellido' => $centroDocentes->sortBy(fn($d) => [strtolower($d->apellido), strtolower($d->nombre)]),
            'dni' => $centroDocentes->sortBy(fn($d) => strtolower($d->dni)),
            default => $centroDocentes,
        };

        return view('admin/ver_docentes', [
            'docentes' => $centroDocentes,
            'sortField' => $sortField
        ]);
    }


    // Método para devolver info detallada de un docente vía AJAX
   public function info($dni)
{
    try {
        // Obtener todos los registros del docente (puede estar en varios centros)
        $docentes = Docente::where('dni', $dni)
            ->with([
                'tutorados.ciclo',
                'tutorados.centro',
                'coordinaciones.ciclo',
                'coordinaciones.centro',
                'modulosImpartidos.modulo',
                'modulosImpartidos.ciclo',
                'modulosImpartidos.centro'
            ])
            ->get();

        if ($docentes->isEmpty()) {
            throw new \Exception("Docente no encontrado");
        }

        // Procesar módulos impartidos (agrupados por centro)
        $modulosPorCentro = [];
        $todosLosModulos = [];
        
        foreach ($docentes as $docente) {
            foreach ($docente->modulosImpartidos as $docencia) {
                $centroId = $docencia->id_centro;
                
                if (!isset($modulosPorCentro[$centroId])) {
                    $modulosPorCentro[$centroId] = [
                        'centro_nombre' => $docencia->centro->nombre ?? 'Centro no disponible',
                        'modulos' => []
                    ];
                }
                
                $moduloData = [
                    'id_modulo' => $docencia->id_modulo,
                    'nombre' => $docencia->modulo->nombre ?? 'Módulo no disponible',
                    'ciclo_nombre' => $docencia->ciclo->nombre ?? 'Ciclo no disponible'
                ];
                
                $modulosPorCentro[$centroId]['modulos'][] = $moduloData;
                $todosLosModulos[] = $moduloData;
            }
        }

        /// Modificar solo la parte de procesamiento de tutorías y coordinaciones
        $tutorias = [];
        $coordinaciones = [];

        foreach ($docentes as $docente) {
            // Procesar tutorías
            if ($docente->tutorados->isNotEmpty()) {
                foreach ($docente->tutorados as $tutoria) {
                    $tutorias[] = [
                        'ciclo_nombre' => $tutoria->ciclo->nombre ?? 'Ciclo no disponible',
                        'centro_nombre' => $tutoria->centro->nombre ?? 'Centro no disponible',
                        'centro_id' => $tutoria->id_centro
                    ];
                }
            }
            
            // Procesar coordinaciones
            if ($docente->coordinaciones->isNotEmpty()) {
                foreach ($docente->coordinaciones as $coordinacion) {
                    $coordinaciones[] = [
                        'ciclo_nombre' => $coordinacion->ciclo->nombre ?? 'Ciclo no disponible',
                        'centro_nombre' => $coordinacion->centro->nombre ?? 'Centro no disponible',
                        'centro_id' => $coordinacion->id_centro
                    ];
                }
            }
        }

        // Eliminar duplicados (por si hay registros repetidos)
        $tutorias = array_unique($tutorias, SORT_REGULAR);
        $coordinaciones = array_unique($coordinaciones, SORT_REGULAR);

        // Obtener todos los DNIs únicos (por si hay variaciones)
        $dnisUnicos = $docentes->pluck('dni')->unique()->values();

        // Obtener todos los emails del docente desde la tabla centro_docente ( Tambien obtiene el nombre del centro al que pertenece )
        $emailPorCentro = CentroDocente::where('dni', $dni)
            ->get(['email', 'id_centro'])
            ->filter(fn($cd) => !empty($cd->email))
            ->map(function ($cd) {
                return [
                    'email' => $cd->email,
                    'centro' => optional($cd->centro)->nombre ?? 'Centro no disponible'
                ];
            })
            ->unique('email') // por si hay duplicados con distintos centros
            ->values();


        return response()->json([
            'nombre' => $docentes->first()->nombre,
            'apellido' => $docentes->first()->apellido,
            'email' => $emailPorCentro,
            'dnis' => $dnisUnicos,
            'es_tutor' => !empty($tutorias),
            'es_coordinador' => !empty($coordinaciones),
            'modulos_por_centro' => array_values($modulosPorCentro),
            'todos_los_modulos' => $todosLosModulos,
            'tutorias' => $tutorias,
            'coordinaciones' => $coordinaciones
        ]);

        

    } catch (\Exception $e) {
        \Log::error("Error en DocenteController@info: " . $e->getMessage());
        return response()->json([
            'error' => 'Error al cargar la información del docente',
            'details' => $e->getMessage()
        ], 500);
    }
}
}
