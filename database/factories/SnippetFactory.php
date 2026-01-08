<?php

namespace Database\Factories;

use App\Models\Snippet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Snippet>
 */
class SnippetFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pull supported languages from config
        $languages = array_keys(config('snippets.languages'));

        return [
            'content' => $this->faker->paragraphs(2, true),
            'language' => $this->faker->randomElement($languages),
        ];
    }
}
