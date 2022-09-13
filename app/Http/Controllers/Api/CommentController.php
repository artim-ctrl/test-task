<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ResourceTrait;
use App\Http\Requests\Comment\IndexCommentRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use ResourceTrait;

    /**
     * Display a listing of the resource.
     *
     * @param IndexCommentRequest $request
     * @return JsonResponse
     */
    public function index(IndexCommentRequest $request): JsonResponse
    {
        $query = Comment::query();
        if ($request->has('search.user_id')) {
            $query->where('user_id', $request->input('search.user_id'));
        }

        if ($request->has('search.comment')) {
            $query->where('comment', 'like', '%' . $request->input('search.comment') . '%');
        }

        if ($request->has('search.entity')) {
            $query->where('entity', $request->input('search.entity'));
        }

        if ($request->has('search.entity_id')) {
            $query->where('entity_id', $request->input('search.entity_id'));
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
     * @param StoreCommentRequest $request
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $requestData = $request->safe();
        if (! $request->has('user_id') || ! Auth::user()->isAdmin()) {
            $requestData = $requestData->merge(['user_id' => Auth::user()->id]);
        }

        $comment = Comment::create($requestData->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $comment,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $comment->user_id !== Auth::user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $requestData = $request->safe();
        if (! Auth::user()->isAdmin() && $request->has('user_id')) {
            $requestData = $requestData->merge(['user_id' => Auth::user()->id]);
        }

        $comment->update($requestData->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $comment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $comment->user_id !== Auth::user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $comment->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
