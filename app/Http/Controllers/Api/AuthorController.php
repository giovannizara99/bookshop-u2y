<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorCreateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $authors = Author::with('books')->get();

        return AuthorResource::collection($authors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorCreateRequest $request
     * @return AuthorResource
     */
    public function store(AuthorCreateRequest $request): AuthorResource
    {
        /* @var Author $author */
        $author = Author::query()->create($request->validated());

        if ($request->has('books_ids')) {
            $author->books()->sync($request->books_ids);
        }

        return AuthorResource::make($author->load('books'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return AuthorResource
     */
    public function show(Request $request, int $id): AuthorResource
    {
        $author = Author::with('books')->findOrFail($id);

        return AuthorResource::make($author);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorCreateRequest $request
     * @param int $id
     * @return AuthorResource
     */
    public function update(AuthorCreateRequest $request, int $id): AuthorResource
    {
        /* @var Author $author */
        $author = Author::query()->findOrFail($id);
        $author->update($request->validated());

        if ($request->has('books_ids')) {
            $author->books()->sync($request->books_ids);
        }

        return AuthorResource::make($author->load('books'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $author = Author::query()->findOrFail($id);
        $success = $author->delete();

        return response()->json([
            'success' => $success
        ], $success ? 204 : 500);
    }
}
