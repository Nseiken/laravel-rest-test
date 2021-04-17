<?php

namespace Tests\Feature\Api\BooksController;

use Tests\TestCase;
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
                '*' => ['book_title', 'cover_url', 'author', 'created_at']
            ]
        ])->assertStatus(Response::HTTP_OK);
    }

    public function test_show_book_api() 
    {
        
    }
}
