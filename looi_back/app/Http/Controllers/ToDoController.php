<?php

namespace App\Http\Controllers;

use App\Helpers\JsonHelper;
use App\Http\Requests\ToDo\ToDoIndexRequest;
use App\Http\Requests\ToDo\ToDoStoreRequest;
use App\Http\Requests\ToDo\ToDoUpdateRequest;
use App\Http\Resources\ToDoResource;
use App\Models\ToDo;
use App\Services\ToDoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ToDoController extends Controller
{
    public function __construct(public readonly ToDoService $toDoService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ToDoIndexRequest $request): AnonymousResourceCollection | JsonResponse
    {
        $paginatedData = ToDo::filter($request)->paginate($request->per_page ?? 10);
        return ToDoResource::collection($paginatedData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ToDoStoreRequest $request): JsonResponse
    {
        $toDo = $this->toDoService->create($request->validated());
        return JsonHelper::success([
            'data' => new ToDoResource($toDo)
        ], Response::HTTP_OK);
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
    public function update(ToDoUpdateRequest $request, ToDo $todo): JsonResponse
    {
        $this->toDoService->edit($todo, $request->validated());
        return JsonHelper::success([
            'data' => new TodoResource($todo)
        ]);
    }

    /**
     * Destroy a resource in storage.
     */
    public function destroy(ToDo $todo): JsonResponse
    {
        $this->toDoService->delete($todo);
        return JsonHelper::success();
    }
}
