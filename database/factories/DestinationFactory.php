<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Destination>
 */
class DestinationFactory extends Factory
{

    protected $model = Destination::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $url = $this->faker->url();

        return [
            'url' => $url,
            'url_hash' => hash('sha256', $url),
        ];
    }

    public function forUrl(string $url): static
    {
        return $this->state(fn() => [
            'url' => $url,
            'url_hash' => hash('sha256', $url),
        ]);
    }
}
