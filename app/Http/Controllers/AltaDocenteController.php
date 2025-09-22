<?php

namespace App\Http\Controllers;

use App\Models\Docente;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\CentroDocente;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class AltaDocenteController extends Controller
{
    public function create()
    {
        $centro = Auth::user()->centro;
        return view('alta_docente', compact('centro'));
    }


    public function store(Request $request)
    {
        $dni = strtolower($request->dni);

        
        $validator = Validator::make($request->all(), [
           'dni' => [
                'required',
                'string',
                'max:10',
                'regex:/^(\d{8}|[XYZ]\d{7})[A-Z]$/i',
                function ($attribute, $value, $fail) use ($request) {
                    if (CentroDocente::where('dni', strtolower($value))
                        ->where('id_centro', $request->id_centro)
                        ->exists()) {
                        $fail('Este docente ya está asignado a este centro.');
                    }
                },
            ],

            //Comprueba si el email existe
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (CentroDocente::where('email', $value)->exists()) {
                        $fail('Este correo electrónico ya está registrado.');
                    }
                },
            ],

            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'id_centro' => 'required|string',
        ]);

        //Si da algun error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // Buscar el docente existente por DNI
            $docente = Docente::where('dni', $dni)->first();

            if ($docente) {
                // Si el nombre o apellido han cambiado, actualizarlos
                $nombreNuevo = ucfirst(strtolower($request->nombre));
                $apellidoNuevo = ucfirst(strtolower($request->apellido));

                $actualizado = false;

                if ($docente->nombre !== $nombreNuevo) {
                    $docente->nombre = $nombreNuevo;
                    $actualizado = true;
                }

                if ($docente->apellido !== $apellidoNuevo) {
                    $docente->apellido = $apellidoNuevo;
                    $actualizado = true;
                }

                if($docente->de_baja) {
                    $docente->de_baja = false;
                    $actualizado = true;
                }

                if ($actualizado) {
                    $docente->save();

                    // Comando moosh para actualizar el docente en Moodle ( Uso de escapehellarg para que los comandos sean seguros y no puedan poner algo malicioso los usuarios )
                    /*$command = "moosh user-update" .
                        " --firstname " . escapeshellarg($request->nombre) . 
                        " --lastname " . escapeshellarg($request->apellido) . 
                        " " . escapeshellarg($dni);

                    $this->ejecutarMoosh($command);*/
                }

            } else {
                // Si no existe, se crea
                $docente = Docente::create([
                    'dni' => $dni,
                    'nombre' => ucfirst(strtolower($request->nombre)),
                    'apellido' => ucfirst(strtolower($request->apellido)),
                ]);

                // Comando moosh para crear nuevo usuario en Moodle ( Uso de escapehellarg para que los comandos sean seguros y no puedan poner algo malicioso los usuarios )
                /*$command = "moosh user-create" .
                    " --email " . escapeshellarg($request->email) .
                    " --password " . escapeshellarg($dni) . // DNI de contraseña
                    " --firstname " . escapeshellarg($request->nombre) .
                    " --lastname " . escapeshellarg($request->apellido) .
                    " " . escapeshellarg($dni); 

                $this->ejecutarMoosh($command); */
            }

            // Asignar el docente al centro
            CentroDocente::create([
                'dni' => $dni,
                'id_centro' => $request->id_centro,
                'email' => $request->email,
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('alta_docente_correcto', 'Docente asignado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Hubo un error al guardar el docente.'])->withInput();
        }

    }

    //Comprueba si el dni existe para autocompletar los campos 'Nombre' y 'Apellido'
    public function comprobarDocente($dni)
    {
        $docente = Docente::where('dni', $dni)->first();

        if ($docente) {
            return response()->json([
                'existe' => true,
                'nombre' => $docente->nombre,
                'apellido' => $docente->apellido,
            ]);
        }

        return response()->json(['existe' => false]);
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
