<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 5);

        $books = Book::paginate(page: $page, perPage: $size);

        return new BookCollection($books);
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
            throw new HttpException(404, "Book not found");
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
            throw new HttpException(404, "Book not found");
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
            throw new HttpException(404, "Book not found");
        }

        $book->delete();

        return response()->json([
            "data" => [
                "message" => "success deleted"
            ]
        ]);
    }
}
