<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentUser>
 */
class DocumentUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $documentId = mt_rand(500, 1000);
//        $documentId = mt_rand(1, 1200);
        return [
            'document_id' => $documentId,
            'user_id' => mt_rand(1, 300),
            'last_viewed_version' => mt_rand(1, 4),
        ];
    }
}

