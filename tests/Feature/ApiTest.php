<?php

namespace Tests\Feature;

use App\Models\Entities;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->withoutMiddleware();
    }

    public function testRerecordingLabels()
    {
        $entity = Entities::first();

        $labels = [1, 4, 21];//типа рандомные айдишники лейблов

        $this->assertNotEquals($entity->labels, implode(',', $labels));

        $requestData = [
            'entity_id' => $entity->id,
            'entity_type' => $entity->type,
            'labels_list' => $labels
        ];

        $this->post('/api/rerecording_labels', $requestData)
            ->assertStatus(204);

        $entity = Entities::find($entity->id);

        $this->assertEquals($entity->labels, implode(',', $labels));
    }

    public function testAddLabel()
    {
        Entities::factory()->create([
            'type' => 'website',
            'title' => 'labels.io',
            'labels' => '1,4,21'//типа рандомные айдишники лейблов
        ]);

        $entities = Entities::get();
        $oldEntity = $entities[count($entities) - 1];

        $labels = [2, 13, 25];//типа рандомные айдишники лейблов

        $requestData = [
            'entity_id' => $oldEntity->id,
            'entity_type' => $oldEntity->type,
            'labels_list' => $labels
        ];

        $this->put('/api/add_labels', $requestData)
            ->assertStatus(204);

        $entity = Entities::find($oldEntity->id);

        $this->assertEquals($entity->labels, $oldEntity->labels . ',' . implode(',', $labels));
    }

    public function testDeleteLabel()
    {
        Entities::factory()->create([
            'type' => 'website',
            'title' => 'labels.io',
            'labels' => '1,3,4,21'//типа рандомные айдишники лейблов
        ]);

        $entities = Entities::get();
        $oldEntity = $entities[count($entities) - 1];

        $labels = [3, 21];//типа рандомные айдишники лейблов

        $requestData = [
            'entity_id' => $oldEntity->id,
            'entity_type' => $oldEntity->type,
            'labels_list' => $labels
        ];

        $this->delete('/api/delete_labels', $requestData)
            ->assertStatus(204);

        $entity = Entities::find($oldEntity->id);

        $this->assertEquals($entity->labels, implode(',', array_diff(explode(',', $oldEntity->labels), $labels)));
    }

    public function testGetLabels()
    {
        Entities::factory()->create([
            'type' => 'website',
            'title' => 'labels.io',
            'labels' => '1,3,4,21'//типа рандомные айдишники лейблов
        ]);

        $entities = Entities::get();
        $entity = $entities[count($entities) - 1];

        $requestData = [
            'entity_id' => $entity->id,
            'entity_type' => $entity->type
        ];

        $response = $this->call('GET', 'api/get_labels', $requestData);
        $response->assertStatus(200)
            ->json();

        $this->assertIsArray($response['items']);

        $this->assertEquals($entity->labels, implode(',', array_column($response['items'], 'id')));
    }
}
