<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ResourceTrait;
use App\Http\Requests\Article\IndexArticleRequest;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use ResourceTrait;

    /**
     * Display a listing of the resource.
     *
     * @param IndexArticleRequest $request
     * @return JsonResponse
     */
    public function index(IndexArticleRequest $request): JsonResponse
    {
        $query = Article::query();
        if ($request->has('search.user_id')) {
            $query->where('user_id', $request->input('search.user_id'));
        }

        if ($request->has('search.name')) {
            $query->where('name', 'like', '%' . $request->input('search.name') . '%');
        }

        if ($request->has('search.article')) {
            $query->where('article', 'like', '%' . $request->input('search.article') . '%');
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
     * @param StoreArticleRequest $request
     * @return JsonResponse
     */
    public function store(StoreArticleRequest $request): JsonResponse
    {
        $requestData = $request->safe();
        if (! $request->has('user_id') || ! Auth::user()->isAdmin()) {
            $requestData = $requestData->merge(['user_id' => Auth::user()->id]);
        }

        $article = Article::create($requestData->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $article,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function show(Article $article): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    public function update(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $article->user_id !== Auth::user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $requestData = $request->safe();
        if (! Auth::user()->isAdmin() && $request->has('user_id')) {
            $requestData = $requestData->merge(['user_id' => Auth::user()->id]);
        }

        $article->update($requestData->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $article,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $article->user_id !== Auth::user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $article->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
