<?php

namespace App\Repositories;

use App\Models\Book;
use App\Traits\EndpointTrait;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;
use Symfony\Component\HttpFoundation\Response;

class BookRepository implements BookRepositoryInterface
{
    use EndpointTrait;

    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getPaginatedBooks()
    {
        return new BookCollection($this->book->with('authors')->paginate(2));
    }

    public function createBooks(BookRequest $request)
    {
        $queryParamsUrl = [
            'bibkeys' => "ISBN:{$request->get('isbn')}",
            'jscmd'   => 'data',
            'format'  => 'json'
        ];

        $urlApi = $this->getEndpoint("https://openlibrary.org/api/books?", $queryParamsUrl);

        $arrayResponseApi = json_decode($urlApi, true);

        if (!empty($arrayResponseApi)) {
            $book = $this->book->create([
                'isbn'       => $request->get('isbn'),
                'book_title' => $arrayResponseApi['ISBN:' . $request->get('isbn')]['title'],
                'cover_url'  => $arrayResponseApi['ISBN:' . $request->get('isbn')]['url'],
            ]);

            $authors = $this->getAuthors($arrayResponseApi['ISBN:' . $request->get('isbn')]['authors']);

            $book->authors()->createMany($authors);

            return response()->json(['success' => $book->load('authors')], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'ISBN no encontrado'], Response::HTTP_NOT_FOUND);
        }
    }

    public function showBook($isbn)
    {
        return response()->xml($this->getXmlResponseBook($isbn), Response::HTTP_OK, [], 'Libros');
    }

    public function deleteBook($isbn)
    {
        $this->book->where('isbn', $isbn)->delete();

        return response()->json(['success'=>'Deleted Succesfully'], Response::HTTP_OK);
    }

    protected function getAuthors($authors)
    {
        $authorsArray = [];

        foreach ($authors as $author) {
            array_push($authorsArray, ['author_name' => $author['name']]);
        }

        return $authorsArray;
    }

    protected function getXmlResponseBook($isbn)
    {
        if ($this->book->where('isbn', $isbn)->count() > 0) {
            $response = (new BookResource($this->book->where('isbn', $isbn)->first()->load('authors')))->response();

            $responseData = $response->getData()->data;

            $arrayResponse = [
                'Libro' => [
                    'Titulo' => $responseData->book_title,
                    'ISBN' => $responseData->isbn,
                    'Caratula' => $responseData->cover_url,
                    'Autores' => collect($responseData->authors)->map(function ($author) {
                        return $author->author_name;
                    })
                ]
            ];
        } else {
            $arrayResponse = ['Libro' => 'Error Libro no encontrado'];
        }

        return $arrayResponse;
    }
}
