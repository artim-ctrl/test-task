<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\IndexArticleRequest;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexArticleRequest $request
     * @return ArticleCollection
     */
    public function index(IndexArticleRequest $request): ArticleCollection
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

        return ArticleCollection::make($paginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return ArticleResource
     */
    public function store(StoreArticleRequest $request): ArticleResource
    {
        $requestData = $request->safe();
        if (! $request->has('user_id') || ! Auth::user()->isAdmin()) {
            $requestData = $requestData->merge(['user_id' => auth()->id()]);
        }

        $article = Article::create($requestData->toArray());

        return ArticleResource::make($article);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return ArticleResource
     */
    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return ArticleResource
     */
    public function update(UpdateArticleRequest $request, Article $article): ArticleResource
    {
        if (! Auth::user()->isAdmin() && $article->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $requestData = $request->safe();
        if (! Auth::user()->isAdmin() && $request->has('user_id')) {
            $requestData = $requestData->merge(['user_id' => auth()->id()]);
        }

        $article->update($requestData->toArray());

        return ArticleResource::make($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        if (! Auth::user()->isAdmin() && $article->user_id !== auth()->id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $article->delete();

        return response()->json();
    }
}
