<?php

namespace App\Services;

use App\Models\ToDo;

class ToDoService
{
    public function create(array $todo): ToDo
    {
        return ToDo::create($todo);
    }

    public function edit(ToDo $todo, $newData): bool
    {
        return $todo->update($newData);
    }

    public function delete(ToDo $todo): bool
    {
        return $todo->delete();
    }
}
