<?php

namespace Database\Seeders;

use App\Models\ToDo;
use Illuminate\Database\Seeder;

class ToDoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ToDo::factory(5)->create()->each(function (ToDo $toDo) {
            //Special treatment goes here.
        });
    }
}
