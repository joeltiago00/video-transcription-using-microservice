<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'path' => fake()->filePath(),
            'mimetype' => fake()->mimeType(),
            'size' => fake()->randomNumber()
        ];
    }
}
