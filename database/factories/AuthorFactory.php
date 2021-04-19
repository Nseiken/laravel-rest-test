<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $books = Book::factory(3)->create();
        
        return [
            'author_name' => $this->faker->name,
            'book_id' => $this->faker->randomElement($books->pluck('id')->toArray()),
        ];
    }
}
