<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use App\Repositories\BookRepositoryInterface;

class BooksController extends Controller
{
    protected $bookInterface;

    public function __construct(BookRepositoryInterface $bookInterface)
    {
        $this->bookInterface = $bookInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->bookInterface->getPaginatedBooks();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        return $this->bookInterface->createBooks($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($isbn)
    {
        return $this->bookInterface->showBook($isbn);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($isbn)
    {
        return $this->bookInterface->deleteBook($isbn);
    }
}
