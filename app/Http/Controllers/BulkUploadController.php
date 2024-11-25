<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BulkUploadController extends Controller
{
    public function store(Request $request)
    {
        $configType = $request->input('config');
        $uploadedFiles = [];

        if ($configType === 'local') {
            $request->validate([
                'folder' => 'required|array',
                'folder.*' => 'file|mimes:xlsx,xls,csv|max:2048',
            ]);

            foreach ($request->file('folder') as $file) {
                $filePath = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');
                $uploadedFiles[] = [
                    'fileName' => $file->getClientOriginalName(),
                    'storedPath' => $filePath,
                ];
            }
        } elseif ($configType === 'aws') {
            $request->validate([
                'bucket_path' => 'required|string',
                'access_key' => 'required|string',
                'secret_key' => 'required|string',
            ]);

            $uploadedFiles[] = [
                'bucketPath' => $request->input('bucket_path'),
                'accessKey' => $request->input('access_key'),
                'secretKey' => $request->input('secret_key'),
            ];
        }

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles,
        ]);
    }
}
