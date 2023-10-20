<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $book = new Book($validated);
        $book->finished = $book->read_page == $book->total_page;
        $book->save();

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            throw new HttpResponseException(response([
                "errors" => "Book not found"
            ], 404));
        }

        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            throw new HttpResponseException(response([
                "errors" => "Book not found"
            ], 404));
        }

        $validated = $request->validated();
        $book->fill($validated);
        $book->save();

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            throw new HttpResponseException(response([
                "errors" => "Book not found"
            ], 404));
        }

        $book->delete();

        return response()->json([
            "message" => "success deleted"
        ]);
    }
}
