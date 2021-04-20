<?php

namespace App\Repositories;

use App\Http\Requests\BookRequest;

interface BookRepositoryInterface {

    public function getPaginatedBooks();

    public function createBooks(BookRequest $request);

    public function showBook($isbn);

    public function deleteBook($isbn);
}