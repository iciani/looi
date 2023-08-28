<?php

namespace App\Http\Requests\ToDo;

use App\Enums\ToDoPriorities;
use App\Enums\ToDoStates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToDoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'sometimes|nullable|string',
            'state' => ['required','string',Rule::in(ToDoStates::states())],
            'thumbnail' => 'sometimes|nullable|url',
            'committed_due_date' => 'sometimes|nullable|date',
            'priority' => ['required','string',Rule::in(ToDoPriorities::priorities())],
        ];
    }
}
