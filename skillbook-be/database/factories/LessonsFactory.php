<?php

namespace Database\Factories;

use App\Models\Lessons;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LessonsFactory extends Factory
{
    protected $model = Lessons::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'progress' => 0,
            'lastaccessedpage' => 1, // or null if you want
        ];
    }
}
