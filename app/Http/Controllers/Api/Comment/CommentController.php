<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\IndexCommentRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexCommentRequest $request
     * @return CommentCollection
     */
    public function index(IndexCommentRequest $request): CommentCollection
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

        return CommentCollection::make($paginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request
     * @return CommentResource
     */
    public function store(StoreCommentRequest $request): CommentResource
    {
        $requestData = $request->safe();
        if (! $request->has('user_id') || ! Auth::user()->isAdmin()) {
            $requestData = $requestData->merge(['user_id' => auth()->id()]);
        }

        $comment = Comment::create($requestData->toArray());

        return CommentResource::make($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return CommentResource
     */
    public function show(Comment $comment): CommentResource
    {
        return CommentResource::make($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param Comment $comment
     * @return CommentResource
     */
    public function update(UpdateCommentRequest $request, Comment $comment): CommentResource
    {
        if (! Auth::user()->isAdmin() && $comment->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $requestData = $request->safe();
        if (! Auth::user()->isAdmin() && $request->has('user_id')) {
            $requestData = $requestData->merge(['user_id' => auth()->id()]);
        }

        $comment->update($requestData->toArray());

        return CommentResource::make($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $comment->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $comment->delete();

        return response()->json();
    }
}
