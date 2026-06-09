<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageUrl = 'https://picsum.photos/640/480';
        $imageContent = file_get_contents($imageUrl);
        $imageName = $this->faker->uuid . '.jpg';
        file_put_contents(public_path('storage/media/' . $imageName), $imageContent);

        return [
            'media_title' => $this->faker->sentence(),
            'media_content' => $this->faker->paragraphs(3, true),
            'media_image' => $imageName,
            'media_category' => $this->faker->randomElement(['News', 'Article', 'Announcement']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
