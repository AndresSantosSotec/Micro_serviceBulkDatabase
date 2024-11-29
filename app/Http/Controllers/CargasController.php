<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargasController extends Controller
{
    /**
     * Obtener las cargas según el paso.
     *
     * @param int $step El número del paso (1: Asociados, 2: Captaciones, 3: Colocaciones)
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCargasByStep($step)
    {
        // Mapear pasos a tipos de carga
        $tipoCargaMap = [
            1 => 'Asociados',
            2 => 'Captaciones',
            3 => 'Colocaciones'
        ];

        // Verificar si el paso es válido
        if (!isset($tipoCargaMap[$step])) {
            return response()->json(['error' => 'Paso no válido'], 400);
        }

        $tipoCarga = $tipoCargaMap[$step];

        // Realizar la consulta con INNER JOIN
        $data = DB::table('cargas')
            ->join('nom', 'cargas.id_tipo_carga', '=', 'nom.id_tipo')
            ->where('nom.nombre_tipo', $tipoCarga)
            ->select(
                'cargas.nombre_archivo',
                'cargas.ruta_archivo',
                'cargas.metadatos',
                'cargas.created_at'
            )
            ->get();

        // Devolver los datos como JSON
        return response()->json($data);
    }
}
