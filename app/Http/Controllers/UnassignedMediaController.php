<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\DestroyMediaRequest;
use App\Http\Requests\Media\UploadMediaRequest;
use App\Models\UnassignedMedia;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UnassignedMediaController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param Request $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function upload(UploadMediaRequest $request): JsonResponse
    {
        if ($request->has('default')) {
            $mediaToUpload = $request->get('default');

            $uploadedMedia = collect([]);

            collect($mediaToUpload)->each(function ($media) use ($uploadedMedia) {
                $model = UnassignedMedia::create();
                $model->processMedia(collect([
                    'default' => [$media],
                ]));

                $uploadedMedia->push($model->getFirstMedia('default'));
            });


            return response()->json(['media' => $uploadedMedia], 200);
        }

        return response()->json('File not provided', 422);
    }

    /**
     * @param Request $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function destroy(DestroyMediaRequest $request, $id): JsonResponse
    {
        $media = Media::findOrFail($id);

        $media->delete();

        return response()->json('Successfully deleted', 200);
    }
}
