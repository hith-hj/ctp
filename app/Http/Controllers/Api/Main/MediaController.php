<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends ApiController
{
    public function uploadMedia(): JsonResponse
    {
        $fileId = uploadFile('media', 'temps');

        return $this->respondSuccess($fileId);
    }

    public function uploadMultiMedia(): JsonResponse
    {
        $fileIds = uploadMultiImages('media', 'temps');

        return $this->respondSuccess($fileIds);
    }

    public function deleteMedia(Request $request): JsonResponse
    {
        if ($request->has('media')) {
            Storage::disk('public')->delete($request->get('media'));

            return $this->respondSuccess('file deleted successfully');
        }

        return $this->respondError('please send media id to delete file');
    }

    public function deleteMultiMedia(Request $request): JsonResponse
    {
        if ($request->has('media')) {
            Storage::disk('public')->delete($request->get('media'));

            return $this->respondSuccess('file deleted successfully');
        }

        return $this->respondError('please send ids array to delete file');
    }
}
