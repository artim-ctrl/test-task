<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ResourceTrait;
use App\Http\Requests\Video\IndexVideoRequest;
use App\Http\Requests\Video\StoreVideoRequest;
use App\Http\Requests\Video\UpdateVideoRequest;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    use ResourceTrait;

    /**
     * Display a listing of the resource.
     *
     * @param IndexVideoRequest $request
     * @return JsonResponse
     */
    public function index(IndexVideoRequest $request): JsonResponse
    {
        $query = Video::query();
        if ($request->has('search.user_id')) {
            $query->where('user_id', $request->input('search.user_id'));
        }

        if ($request->has('search.name')) {
            $query->where('name', 'like', '%' . $request->input('search.name') . '%');
        }

        $paginate = $query->paginate($request->input('limit'));

        return response()->json([
            'status' => 'success',
            'data' => $paginate->all(),
            'meta' => $this->getPaginationInfo($paginate),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVideoRequest $request
     * @return JsonResponse
     */
    public function store(StoreVideoRequest $request): JsonResponse
    {
        $requestData = $request->safe();
        if (! $request->has('user_id') || ! Auth::user()->isAdmin()) {
            $requestData = $requestData->merge(['user_id' => auth()->id()]);
        }

        $video = Video::create($requestData->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $video,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return JsonResponse
     */
    public function show(Video $video): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $video,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVideoRequest $request
     * @param Video $video
     * @return JsonResponse
     */
    public function update(UpdateVideoRequest $request, Video $video): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $video->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $requestData = $request->safe();
        if (! Auth::user()->isAdmin() && $request->has('user_id')) {
            $requestData = $requestData->merge(['user_id' => auth()->id()]);
        }

        $video->update($requestData->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $video,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Video $video
     * @return JsonResponse
     */
    public function destroy(Video $video): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $video->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $video->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
