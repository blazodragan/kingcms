<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $count = 1;
        $title = $this->faker->sentence;
        $slug = Str::slug((string)$title) . '-' . (int)$count;

        
        return [
            'title' => $this->faker->sentence,
            'slug'  => $slug,
            'perex' => $this->faker->text,
            'content' => $this->faker->paragraph,
            'reference_link' => $this->faker->url,
            'user_id' => User::factory(),
 
            'deleted_at' => null,
            'status' => ['Published', 'Draft', 'Review'][rand(0, 2)],
        ];
    }
}
