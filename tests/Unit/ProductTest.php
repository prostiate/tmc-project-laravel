<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
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

        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_store()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $data = [
            'categoryId' => Category::inRandomOrder()->first()->id,
            'sku' => $this->faker->country,
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(6),
            'stock' => $this->faker->randomNumber(3),
        ];
        $response = $this->post('/api/products', $data);

        $response->assertStatus(200);
    }
}
