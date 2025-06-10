<?php

namespace Database\Factories;

use App\Models\LessonsPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LessonsPageFactory extends Factory
{
    protected $model = LessonsPage::class;

    public function definition()
    {
        return [
            'page' => $this->faker->numberBetween(1, 3),
            'content_1' => $this->faker->paragraph,
            'content_2' => $this->faker->paragraph,
            'code_1' => $this->faker->text(),
            'code_2' => $this->faker->text(),
        ];
    }
}
