<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $books = Book::with('authors')->get();

        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookCreateRequest $request
     * @return Response|BookResource
     */
    public function store(BookCreateRequest $request): Response|BookResource
    {
        /* @var Book $book */
        $book = Book::query()->create($request->validated());

        if ($request->has('authors_ids')) {
            $book->authors()->sync($request->authors_ids);
        }

        return BookResource::make($book->load('authors'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return BookResource
     */
    public function show(Request $request, int $id): BookResource
    {
        $book = Book::with('authors')->findOrFail($id);

        return BookResource::make($book->load('authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookCreateRequest $request
     * @param int $id
     * @return BookResource
     */
    public function update(BookCreateRequest $request, int $id): BookResource
    {
        /* @var Book $book */
        $book = Book::query()->findOrFail($id);
        $book->update($request->validated());

        if ($request->has('authors_ids')) {
            $book->authors()->sync($request->authors_ids);
        }

        return BookResource::make($book->load('authors'));
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
        $book = Book::query()->findOrFail($id);
        $success = $book->delete();

        return response()->json([
            'success' => $success
        ], $success ? 204 : 500);
    }
}
