<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\BookCollection;
use Symfony\Component\HttpFoundation\Response;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BookCollection(Book::with('authors')->paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required'
        ]);
        $response = Http::get('https://openlibrary.org/api/books?bibkeys=ISBN:1878058517&jscmd=data&format=json');
        return $response->body();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($isbn)
    {
        return response()->xml($this->getXmlResponseBook($isbn), Response::HTTP_OK, [], 'Libros');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }

    protected function getXmlResponseBook($isbn)
    {
        if (Book::where('isbn', $isbn)->count() > 0) {
            $response = (new BookResource(Book::where('isbn', $isbn)->first()->load('authors')))->response();

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
