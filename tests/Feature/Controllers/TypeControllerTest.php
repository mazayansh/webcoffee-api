<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Type;

class TypeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_coffee_type_index_success()
    {
        Type::factory()->count(9)->create();

        $response = $this->getJson('/api/v1/types')
                        ->assertStatus(200)
                        ->assertJson(fn (AssertableJson $json) => 
                            $json->has('data', 9)
                        );
    }
}
