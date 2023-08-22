<?php

namespace Tests\Unit\Api\V1;

use App\Enums\ToDoPriorities;
use App\Enums\ToDoStates;
use App\Helpers\TestsHelper;
use App\Http\Resources\ToDoResource;
use App\Models\ToDo;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ToDoTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testGetIndexToDos(): void
    {
        $this->assertEquals(0, ToDo::all()->count());
        $cant = 2;
        $toDos = ToDo::factory($cant)->create();
        $response = $this->actingAs($this->user)->get("/api/todos");
        TestsHelper::dumpApiResponsesWithErrors($response);
        $jsonResponse = json_decode($response->getContent(), true);
        $response->assertStatus(Response::HTTP_OK)->assertJsonStructure(
            [
                "data",
                "links",
                "meta"
            ]
        )->assertJsonPath('data', ToDoResource::collection($toDos)->toArray(new \Illuminate\Http\Request()));
        $this->assertEquals($cant, count($jsonResponse['data']));
    }

    public function testStoreToDo(): void
    {
        $this->assertEquals(0, ToDo::all()->count());
        $data = [
            'title' => $this->faker->words(rand(1, 3), true),
            'description' => $this->faker->paragraph(rand(10, 50)),
            'state' => $this->faker->randomElement(ToDoStates::states()),
            'thumbnail' => $this->faker->imageUrl(),
            'committed_due_date' => $this->faker->dateTimeBetween('now', '+4 week')->format('Y-m-d'),
            'priority' => $this->faker->randomElement(ToDoPriorities::priorities()),
        ];
        $response = $this->actingAs($this->user)->post("/api/todos", $data);
        TestsHelper::dumpApiResponsesWithErrors($response);
        $toDo = ToDo::firstOrFail();
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true,
                'data' => (new ToDoResource($toDo))->toArray(new \Illuminate\Http\Request())
            ]);
    }
}
