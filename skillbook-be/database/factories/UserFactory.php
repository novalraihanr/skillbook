<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'role' => 'teacher',
            'level' => 0,
            'email_verified_at' => now(),
            'password' => 'Noval1234', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Create 3 Courses and attach them to the user via the pivot table
            $courses = Course::factory()->count(3)->create();
            $user->courses()->attach($courses);

            $courses->each(function ($course) {
                // Create 3 Lessons for each Course
                \App\Models\Lessons::factory()->count(3)->create(['course_id' => $course->course_id])
                    ->each(function ($lesson) {
                        // Create 3 LessonPages for each Lesson
                        \App\Models\LessonsPage::factory()->count(3)->sequence(
                            ['page' => 1],
                            ['page' => 2],
                            ['page' => 3]
                        )->create(['lessons_id' => $lesson->lessons_id]);

                        // Create 3 Quizzes for each Lesson
                        \App\Models\Quiz::factory()->count(3)->sequence(
                            ['page' => 1],
                            ['page' => 2],
                            ['page' => 3]
                        )->create(['lessons_id' => $lesson->lessons_id]);
                    });
            });
        });
    }
}
