<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $authors = Author::factory(3)->create();
        
        return [
            'author_id' => $this->faker->randomElement($authors->pluck('id')->toArray()),
            'book_title' => $this->faker->sentence(),
            'cover_url' => $this->faker->imageUrl()
        ];
    }
}
