<?php

namespace App\Http\Controllers\FileUpload;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUpload\FileUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Upload\FileUpload\FileUpload;

class FileUploadController extends Controller
{
    public function __invoke(FileUploadRequest $request, FileUpload $fileUpload): Response
    {
        $fileUpload->handle($request->validated());

        return response()->noContent();
    }
}
