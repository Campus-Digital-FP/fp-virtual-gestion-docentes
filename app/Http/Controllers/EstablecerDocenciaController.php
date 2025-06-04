<?php

namespace App\Http\Controllers;

use App\Models\Docencia;
use App\Models\Ciclo;
use App\Models\Modulo;
use App\Models\DocenteCicloModulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class EstablecerDocenciaController extends Controller
{
    protected $model = DocenteCicloModulo::class;

    public function index(Request $request)
    {
        $user = Auth::user();
        $centro = $user->centro;
        
        // Obtener docencias con relaciones
        $docencias = DocenteCicloModulo::with(['docente', 'ciclo', 'modulo'])
            ->where('id_centro', $centro->id_centro)
            ->get();

        // Ordenación (se mantiene igual)
        $sortField = $request->input('sort', 'nombre');
        $docencias = $this->sortDocencias($docencias, $sortField);

        // Ciclos del centro
        $ciclos = $centro->ciclos;
        
        // Módulos disponibles para los ciclos del centro
        $modulos = Modulo::whereHas('ciclos', function($query) use ($ciclos) {
            $query->whereIn('ciclo_modulo.id_ciclo', $ciclos->pluck('id_ciclo')); 
        })
        ->orderBy('nombre')
        ->get();
        
        
        // Docentes del centro (se mantiene igual)
        $docentes = \App\Models\Docente::whereIn('dni', function ($query) use ($centro) {
            $query->select('dni')
                ->from('centro_docente')
                ->where('id_centro', $centro->id_centro);
        })->get(['dni', 'nombre', 'apellido']);
        
        return view('establecer_docencia', compact('ciclos', 'modulos', 'docentes', 'docencias', 'sortField'));
    }

    private function sortDocencias($docencias, $sortField)
    {
        return match ($sortField) {
            'ciclo' => $docencias->sortBy(fn($d) => strtolower($d->ciclo->nombre)),
            'modulo' => $docencias->sortBy(fn($d) => strtolower($d->modulo->nombre)),
            'nombre' => $docencias->sortBy(fn($d) => [strtolower($d->docente->nombre), strtolower($d->docente->apellido)]),
            'apellido' => $docencias->sortBy(fn($d) => [strtolower($d->docente->apellido), strtolower($d->docente->nombre)]),
            default => $docencias->sortBy(fn($d) => strtolower($d->docente->$sortField)),
        };
    }

    public function store(Request $request)
    {  
        $request->validate([
            'id_ciclo' => 'required|exists:ciclos,id_ciclo',
            'id_modulo' => [
                'required',
                'exists:modulos,id_modulo',
                Rule::exists('ciclo_modulo')->where(function ($query) use ($request) {
                    $query->where('id_ciclo', $request->id_ciclo)
                          ->where('id_modulo', $request->id_modulo);
                })
            ],
            'dni' => 'required|string|exists:docentes,dni',
        ]);
        $idCentro = Auth::user()->id_centro;

        // Verificar si ya existe 
        $existe = Docencia::where('id_centro', $idCentro)
            ->where('id_ciclo', $request->id_ciclo)
            ->where('id_modulo', $request->id_modulo)
            ->exists();

        if ($existe) {
            return redirect()->back()->withErrors(['id_modulo' => 'Este módulo ya tiene un docente asignado.']);
        }


        // Crear la docencia
        $this->model::create([
            'id_centro' => $idCentro,
            'id_ciclo' => $request->id_ciclo,
            'id_modulo' => $request->id_modulo,
            'dni' => $request->dni,
        ]);

        return redirect()->route('establecer_docencia.index')->with('success', 'Docencia asignada correctamente.');
    }

    public function destroy($id)
    {
        $docencia = Docencia::findOrFail($id);
        $docencia->delete();

        return redirect()->back()->with('success', 'Docencia eliminada correctamente.');
    }

    public function getModulosPorCiclo($id)
    {
        $modulos = Modulo::whereHas('ciclos', function($query) use ($id) {
                $query->where('ciclo_modulo.id_ciclo', $id);
            })
            ->select('id_modulo', 'nombre')
            ->get();
    
        return response()->json($modulos);
    }


}
