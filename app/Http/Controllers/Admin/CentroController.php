<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Centro;
use App\Models\CentroCiclo;
use App\Models\CentroDocente;
use App\Models\Docente;
use App\Models\Ciclo;
use App\Models\Tutor;
use App\Models\Coordinador;
use App\Models\CicloModulo;
use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\DocenteCicloModulo;
use App\Models\Docencia;


class CentroController extends Controller
{
    // Mostrar listado de centros con ciclos
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'nombre_centro');
        $allowedSorts = ['id_centro', 'nombre_centro', 'nombre_ciclo'];

        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'nombre_centro';
        }

        // Obtener todos los centros con sus ciclos
        $centrosCiclos = CentroCiclo::with(['centro', 'ciclo'])
            ->join('centros', 'centro_ciclo.id_centro', '=', 'centros.id_centro')
            ->join('ciclos', 'centro_ciclo.id_ciclo', '=', 'ciclos.id_ciclo')
            ->select(
                'centro_ciclo.id_centro',
                'centros.nombre as nombre_centro',
                'centro_ciclo.id_ciclo',
                'ciclos.nombre as nombre_ciclo'
            )
            ->get()
            ->map(function ($cc) {
                return (object) [
                    'id_centro' => $cc->id_centro,
                    'nombre_centro' => $cc->nombre_centro,
                    'id_ciclo' => $cc->id_ciclo,
                    'nombre_ciclo' => $cc->nombre_ciclo,
                ];
            });

        // Ordenar según el campo solicitado
        $centrosCiclos = match ($sortField) {
            'id_centro' => $centrosCiclos->sortBy('id_centro'),
            'nombre_centro' => $centrosCiclos->sortBy('nombre_centro'),
            'nombre_ciclo' => $centrosCiclos->sortBy('nombre_ciclo'),
            default => $centrosCiclos,
        };

        return view('admin.ver_centros', [
            'centrosCiclos' => $centrosCiclos,
            'sortField' => $sortField
        ]);
    }

    // Método para devolver info detallada de un centro (y ciclo si se especifica)
   public function info($idCentro, Request $request)
    {
        try {
            $cicloId = $request->query('ciclo');
            
            if (!$cicloId) {
                return response()->json(['error' => 'Se requiere especificar un ciclo'], 400);
            }

            \DB::enableQueryLog();

            // Obtener información del centro
            $centro = Centro::findOrFail($idCentro);

            // Obtener información del ciclo
            $ciclo = Ciclo::findOrFail($cicloId);

            // Obtener tutor con su email para este centro
            $tutor = Tutor::where('id_ciclo', $cicloId)
                ->where('id_centro', $idCentro)
                ->with(['docente' => function($query) use ($idCentro) {
                    $query->with(['centros' => function($q) use ($idCentro) {
                        $q->where('centro_docente.id_centro', $idCentro)
                        ->select('centro_docente.email', 'centro_docente.dni');
                    }]);
                }])
                ->first();

            // Obtener coordinador con su email para este centro
            $coordinador = Coordinador::where('id_ciclo', $cicloId)
                ->where('id_centro', $idCentro)
                ->with(['docente' => function($query) use ($idCentro) {
                    $query->with(['centros' => function($q) use ($idCentro) {
                        $q->where('centro_docente.id_centro', $idCentro)
                        ->select('centro_docente.email', 'centro_docente.dni');
                    }]);
                }])
                ->first();

            // Obtener módulos filtrando por centro
            $modulos = CicloModulo::where('id_ciclo', $cicloId)
                ->with(['modulo', 'docencias' => function($query) use ($idCentro) {
                    $query->where('id_centro', $idCentro)
                        ->with('docente');
                }])
                ->get()
                ->map(function ($cm) use ($idCentro) {
                    // Solo tomamos la primera docencia (asumiendo que hay solo una por módulo en este centro)
                    $docencia = $cm->docencias->first();
                    $docente = $docencia?->docente;

                    $email = $docente ? $docente->emailEnCentro($idCentro) : null;

                    return [
                        'id_modulo' => $cm->modulo->id_modulo,
                        'nombre' => $cm->modulo->nombre,
                        'docente' => $docente ? [
                            'dni' => $docente->dni,
                            'nombre' => $docente->nombre,
                            'apellido' => $docente->apellido,
                            'email' => $email,
                        ] : null,
                    ];
                });

            \Log::info("Consultas ejecutadas: ", \DB::getQueryLog());

            // Preparar respuesta
            $response = [
                'centro' => [
                    'id_centro' => $centro->id_centro,
                    'nombre' => $centro->nombre
                ],
                'ciclo' => [
                    'id_ciclo' => $ciclo->id_ciclo,
                    'nombre' => $ciclo->nombre,
                    'modulos' => $modulos
                ],
                'tutor' => null,
                'coordinador' => null
            ];

            // Procesar tutor si existe
            if ($tutor && $tutor->docente) {
                $response['tutor'] = [
                    'dni' => $tutor->dni,
                    'nombre' => $tutor->docente->nombre,
                    'apellido' => $tutor->docente->apellido,
                    'email' => $tutor->docente->emailEnCentro($idCentro)
                ];
            }

            // Procesar coordinador si existe
            if ($coordinador && $coordinador->docente) {
                $response['coordinador'] = [
                    'dni' => $coordinador->dni,
                    'nombre' => $coordinador->docente->nombre,
                    'apellido' => $coordinador->docente->apellido,
                    'email' => $coordinador->docente->emailEnCentro($idCentro)
                ];
            }

            return response()->json($response);

        } catch (\Exception $e) {
            \Log::error("Error en CentroController@info: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'error' => 'Error al cargar la información del centro/ciclo',
                'details' => $e->getMessage(),
                'trace' => env('APP_DEBUG') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function exportCentrosCSV()
{
    // Obtenemos todos los ciclos-modulos por centro primero
    $centrosCiclosModulos = CentroCiclo::with([
        'centro:id_centro',
        'ciclo.modulos' => function($query) {
            $query->select('modulos.id_modulo', 'modulos.nombre');
        }
    ])
    ->get();

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=centros_modulos_docentes_".now()->format('Y-m-d').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $callback = function() use ($centrosCiclosModulos) {
        $file = fopen('php://output', 'w');
        fwrite($file, "\xEF\xBB\xBF");
        fputcsv($file, [
            'Código Centro',
            'Código Ciclo',            
            'Código Módulo',              
            'DNI Docente',
            'Nombre Docente',
            'Apellido Docente'
        ], ';');
        
        foreach ($centrosCiclosModulos as $cc) {
            foreach ($cc->ciclo->modulos as $modulo) {
                // Buscamos si existe docencia para este centro-ciclo-modulo
                $docencia = Docencia::where('id_centro', $cc->id_centro)
                    ->where('id_ciclo', $cc->id_ciclo)
                    ->where('id_modulo', $modulo->id_modulo)
                    ->with('docente:dni,nombre,apellido')
                    ->first();
                
                fputcsv($file, [
                    $cc->id_centro,
                    $cc->id_ciclo,
                    $modulo->id_modulo,
                    $docencia->docente->dni ?? 'SIN DOCENTE',
                    $docencia->docente->nombre ?? 'SIN DOCENTE',
                    $docencia->docente->apellido ?? 'SIN DOCENTE'
                ], ';');
            }
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}