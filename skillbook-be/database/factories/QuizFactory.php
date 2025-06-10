<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        $answerA = $this->faker->sentence;
        $answerB = $this->faker->sentence;
        $answerC = $this->faker->sentence;
        $answerD = $this->faker->sentence;

        $correctAnswerValues = [
            'a' => $answerA,
            'b' => $answerB,
            'c' => $answerC,
            'd' => $answerD,
        ];

        $correctKey = $this->faker->randomElement(['a', 'b', 'c', 'd']);

        return [
            'question' => $this->faker->sentence,
            'answer_a' => $answerA,
            'answer_b' => $answerB,
            'answer_c' => $answerC,
            'answer_d' => $answerD,
            'correct_ans' => $correctAnswerValues[$correctKey],
            'score' => 33,
        ];
    }
}
