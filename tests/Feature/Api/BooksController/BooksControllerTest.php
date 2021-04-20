<?php

namespace Tests\Feature\Api\BooksController;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_books_api()
    {
        $response = $this->json('GET', 'api/books');

        $response->assertJsonStructure([
            'data' => [
                '*' => ['book_title', 'cover_url', 'authors', 'created_at']
            ]
        ])->assertStatus(Response::HTTP_OK);
    }

    public function test_show_book_response_ok() 
    {
        $book = $this->createFactoryBook();

        $response = $this->json('GET', "api/books/{$book->isbn}");
        
        $this->assertDatabaseHas('books', [
            'isbn' => $book->isbn
        ]);
        
        $response->assertStatus(Response::HTTP_OK);
    }


    protected function createFactoryBook()
    {
        return Book::factory()->create();
    }
}
