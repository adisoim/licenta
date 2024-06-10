<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    public function download($path): BinaryFileResponse
    {
        $filePath = public_path('pdfs/books/' . $path);
        if (file_exists($filePath)) {
            return Response::download($filePath);
        } else {
            return abort(404, 'File not found');
        }
    }
}
