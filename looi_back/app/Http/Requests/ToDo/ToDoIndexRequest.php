<?php

namespace App\Http\Requests\ToDo;

use App\Enums\ToDoStates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToDoIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|nullable|integer|min:1',
            'state' => ['sometimes','nullable','string',Rule::in(ToDoStates::states())],
            'airing_date' => 'sometimes|nullable|date',
            'sort' => 'sometimes|nullable|string',
        ];
    }
}
