<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MediaUploader;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Http\Resources\MediaResource;
use Modules\Core\Models\PendingMedia;
use Plank\Mediable\Exceptions\MediaUploadException;
use Plank\Mediable\HandlesMediaUploadExceptions;

class PendingMediaController extends ApiController
{
    use HandlesMediaUploadExceptions;

    /**
     * Upload pending media.
     */
    public function store(string $draftId, Request $request): JsonResponse
    {
        try {
            $media = MediaUploader::fromSource($request->file('file'))
                ->toDirectory('pending-attachments')
                ->upload();

            $media->markAsPending($draftId);
        } catch (MediaUploadException $e) {
            /** @var \Symfony\Component\HttpKernel\Exception\HttpException */
            $exception = $this->transformMediaUploadException($e);

            return $this->response(['message' => $exception->getMessage()], $exception->getStatusCode());
        }

        return $this->response(new MediaResource($media->load('pendingData')), 201);
    }

    /**
     * Destroy pending media.
     */
    public function destroy(string $pendingMediaId): JsonResponse
    {
        $media = PendingMedia::findOrFail($pendingMediaId);

        $media->purge();

        return $this->response('', 204);
    }
}
