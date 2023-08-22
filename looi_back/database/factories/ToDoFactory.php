<?php

namespace Database\Factories;

use App\Enums\ToDoPriorities;
use App\Enums\ToDoStates;
use App\Models\ToDo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ToDo>
 */
class ToDoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToDo::class;

    /**
     * Define the modclearel's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(rand(1, 3), true),
            'description' => $this->faker->paragraph(rand(10, 50)),
            'state' => $this->faker->randomElement(ToDoStates::states()),
            'thumbnail' => $this->faker->imageUrl(),
            'committed_due_date' => $this->faker->dateTimeBetween('now', '+4 week')->format('Y-m-d'),
            'priority' => $this->faker->randomElement(ToDoPriorities::priorities()),
        ];
    }
}
