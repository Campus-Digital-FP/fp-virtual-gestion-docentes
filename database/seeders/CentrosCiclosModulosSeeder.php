<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentrosCiclosModulosSeeder extends Seeder
{
    public function run()
    {
        // El csv está en zz_infoCentros.csv
        $csvDataRaw = file_get_contents('database/seeders/zz_infoCentros.csv');

        $lines = explode("\n", trim($csvDataRaw));

        foreach ($lines as $line) {
            $columns = str_getcsv($line);

            if (count($columns) < 5) continue;

            $category = $columns[1];
            $shortname = $columns[2];
            $fullname = $columns[3];

            // Parsear category
            $categoryParts = explode('/', $category);
            $nombreCentro = $categoryParts[1] ?? null;  // Después del primer /
            $nombreCiclo = $categoryParts[2] ?? null;   // Después del segundo /

            // Parsear shortname "22002521-ADG201-5367"
            $shortnameParts = explode('-', $shortname);
            $idCentro = filter_var(trim($shortnameParts[0]), FILTER_SANITIZE_NUMBER_INT) ?? null;
            $idCiclo = $shortnameParts[1] ?? null;
            $idModulo = $shortnameParts[2] ?? null;

            // Insertar centro
            if ($idCentro && $nombreCentro) {
                DB::table('centros')->updateOrInsert(
                    ['id_centro' => $idCentro],
                    ['nombre' => $nombreCentro]
                );
            }

            // Insertar ciclo
            if ($idCiclo && $nombreCiclo) {
                DB::table('ciclos')->updateOrInsert(
                    ['id_ciclo' => $idCiclo],
                    ['nombre' => $nombreCiclo]
                );
            }

            // Insertar módulo
            if ($idModulo) {
                DB::table('modulos')->updateOrInsert(
                    ['id_modulo' => $idModulo],
                    ['nombre' => $fullname]
                );
            }

            // Validar y insertar relación centro_ciclo
            if ($idCentro && $idCiclo) {
                $existsCentro = DB::table('centros')->where('id_centro', $idCentro)->exists();
                $existsCiclo = DB::table('ciclos')->where('id_ciclo', $idCiclo)->exists();

                if ($existsCentro && $existsCiclo) {
                    DB::table('centro_ciclo')->updateOrInsert(
                        ['id_centro' => $idCentro, 'id_ciclo' => $idCiclo]
                    );
                }
            }

            // Validar y insertar relación ciclo_modulo
            if ($idCiclo && $idModulo) {
                $existsCiclo = DB::table('ciclos')->where('id_ciclo', $idCiclo)->exists();
                $existsModulo = DB::table('modulos')->where('id_modulo', $idModulo)->exists();

                if ($existsCiclo && $existsModulo) {
                    DB::table('ciclo_modulo')->updateOrInsert(
                        ['id_ciclo' => $idCiclo, 'id_modulo' => $idModulo]
                    );
                }
            }
        }
    }
}
