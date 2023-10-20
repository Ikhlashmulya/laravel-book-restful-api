<?php

namespace Tests\Feature;

use App\Models\Book;
use Database\Seeders\BookSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetBook()
    {
        $this->seed(BookSeeder::class);
        $this->get('/api/book')->assertStatus(200);
        DB::table('books')->truncate();
    }

    public function testGetBookByIdSuccess()
    {
        $this->seed(BookSeeder::class);
        $book = Book::query()->limit(1)->first();
        $this->get('/api/book/' . $book->id)->assertStatus(200);
        DB::table('books')->truncate();
    }

    public function testGetBookByIdErrorNotFound()
    {
        $this->get('/api/book/3')->assertStatus(404);
    }

    public function testPostBookSuccess()
    {
        $this->post('/api/book', [
            "name" => "test",
            "author" => "test",
            "summary" => "test",
            "publisher" => "test",
            "total_page" => 10,
            "read_page" => 9
        ])
            ->assertStatus(201);

        $this->assertNotNull(Book::where('name', 'test')->first());
    }

    public function testPostBookValidationFailed()
    {
        $this->post('/api/book', [
            "name" => "",
            "author" => "",
            "summary" => "",
            "total_page" => 10,
            "read_page" => 9
        ])
            ->assertStatus(400);
    }

    public function testPostBookValidationFailedReadPageGreaterThanTotalPage()
    {
        $this->post('/api/book', [
            "name" => "test",
            "author" => "test",
            "summary" => "test",
            "author" => "test",
            "total_page" => 10,
            "read_page" => 90
        ])
            ->assertStatus(400);
    }

    public function testPutBookSuccess()
    {
        $this->seed(BookSeeder::class);
        $book = Book::query()->limit(1)->first();
        $this->put('/api/book/' . $book->id, [
            "name" => "edited",
            "author" => "edited",
            "publisher" => "edited",
            "summary" => "edited",
            "author" => "edited",
            "total_page" => 10,
            "read_page" => 9
        ])
            ->assertStatus(200);

        $UpdateBook = Book::find($book->id);
        $this->assertEquals("edited", $UpdateBook->name);
        DB::table('books')->truncate();
    }

    public function testPutBookErrorNotFound()
    {
        $this->put('/api/book/90', [
            "name" => "edited",
            "author" => "edited",
            "publisher" => "edited",
            "summary" => "edited",
            "author" => "edited",
            "total_page" => 10,
            "read_page" => 9
        ])
            ->assertStatus(404);
    }

    public function testDeleteBookSuccess()
    {
        $this->seed(BookSeeder::class);
        $book = Book::query()->limit(1)->first();

        $this->delete('/api/book/' . $book->id)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'success deleted'
            ]);

        $this->assertNull(Book::find($book->id));
    }

    public function testDeleteBookErrorNotFound()
    {
        $this->delete('/api/book/99')->assertStatus(404);
    }
}
