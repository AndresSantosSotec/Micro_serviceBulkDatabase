<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Validar los archivos
        $request->validate([
            'folder' => 'required|array',
            'folder.*' => 'file|mimes:xlsx,xls,csv|max:2048', // Limita a Excel y CSV
        ]);

        $uploadedFiles = [];
        foreach ($request->file('folder') as $file) {
            // Ruta temporal del archivo
            $tempPath = $file->getPathname();

            // Nombre del archivo
            $fileName = $file->getClientOriginalName();

            // Mover archivo al almacenamiento
            $filePath = $file->storeAs('uploads', $fileName, 'public'); // Guarda en `storage/app/public/uploads`

            $uploadedFiles[] = [
                'tempPath' => $tempPath,
                'fileName' => $fileName,
                'storedPath' => $filePath,
            ];
        }

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles,
        ]);
    }
}
