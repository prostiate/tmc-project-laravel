<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
    }

    public function test_store()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $data = [
            'name' => $this->faker->name(),
        ];
        $response = $this->post('/api/categories', $data);

        $response->assertStatus(200);
    }
}
