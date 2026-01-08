<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LinkFactory extends Factory
{
    protected $model = Destination::class;

    public function definition(): array
    {
        return [
            'destination' => Destination::factory(),
            'is_active' => true,
            'expires_at' => null,
            'clicks' => 0,
            'last_accessed' => null,
        ];
    }

    /**
     * Link that is expired.
     */
    public function expired(): static
    {
        return $this->state(fn () => [
            'expires_at' => Carbon::now()->subDay(),
        ]);
    }

    /**
     * Link that is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    /**
     * Link that has been accessed.
     */
    public function accessed(): static
    {
        return $this->state(fn () => [
            'clicks' => $this->faker->numberBetween(1, 100),
            'last_accessed' => Carbon::now()->subMinutes(
                $this->faker->numberBetween(1, 1440)
            ),
        ]);
    }
}
