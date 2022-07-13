<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Roast;

class RoastControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_roast_index_success()
    {
        Roast::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/roasts')
                        ->assertStatus(200)
                        ->assertJson(fn (AssertableJson $json) => 
                            $json->has('data', 5)
                        );
    }
}
