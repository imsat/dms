<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentVersion>
 */
class DocumentVersionFactory extends Factory
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
        $sentence = fake()->sentence(mt_rand(5, 7));
        $bodyContent = [];
        $bodyContent['introduction'] = '<ul><li>' . $sentence . '\t<ul><li>';
        $bodyContent['facts'] = '<ul><li>' . $sentence . '\t<ul><li>';
        $bodyContent['summary'] = '<ul><li>' . $sentence . '\t<ul><li>';
        $tagsContent = '<ul><li>' . $sentence . '\t<ul><li>';
        return [
            'document_id' => $documentId,
            'version' => mt_rand(1, 4),
            'body_content' => json_encode($bodyContent),
            'tags_content' => json_encode($tagsContent),
        ];
    }
}
