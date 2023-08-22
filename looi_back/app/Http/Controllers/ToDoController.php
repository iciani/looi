<?php

namespace App\Http\Controllers;

use App\Enums\ToDoPriorities;
use App\Enums\ToDoStates;
use App\Helpers\JsonHelper;
use App\Http\Resources\ToDoResource;
use App\Models\ToDo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection | JsonResponse
    {
        $request->validate([
            'per_page' => 'sometimes|nullable|integer|min:1',
            'state' => ['sometimes','nullable','string',Rule::in(ToDoStates::states())],
            'airing_date' => 'sometimes|nullable|date',
            'sort' => 'sometimes|nullable|string',
        ]);
        $paginatedData = ToDo::filter($request)->paginate($request->per_page ?? 10);
        return ToDoResource::collection($paginatedData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'sometimes|nullable|string',
            'state' => ['required','string',Rule::in(ToDoStates::states())],
            'thumbnail' => 'sometimes|nullable|url',
            'committed_due_date' => 'sometimes|nullable|date',
            'priority' => ['required','string',Rule::in(ToDoPriorities::priorities())],
        ]);
        $toDo = ToDo::create($request->all());
        return JsonHelper::success(['data' => new ToDoResource($toDo)], Response::HTTP_OK);
    }

    /**
     * Show a resource.
     */
    public function show(ToDo $todo): JsonResponse
    {
        return JsonHelper::success([
            'data' => new ToDoResource($todo)
        ]);
    }

    /**
     * Update a resource in storage.
     */
    public function update(Request $request, ToDo $todo): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'sometimes|nullable|string',
            'state' => ['required','string',Rule::in(ToDoStates::states())],
            'thumbnail' => 'sometimes|nullable|url',
            'committed_due_date' => 'sometimes|nullable|date',
            'priority' => ['required','string',Rule::in(ToDoPriorities::priorities())],
        ]);
        $todo->update($request->all());
        return JsonHelper::success([
            'data' => new TodoResource($todo)
        ]);
    }

    /**
     * Destroy a resource in storage.
     */
    public function destroy(ToDo $todo): JsonResponse
    {
        $todo->delete();
        return JsonHelper::success();
    }
}
