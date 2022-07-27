<?php

namespace Tests\Unit\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\TypeRepository;
use App\Models\Type;

class TypeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TypeRepository $typeRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->typeRepository = new TypeRepository();
    }

    public function test_get_type_index_success()
    {
        Type::factory(5)->create();

        $typeIndexCount = Type::all()->count();

        $this->assertEquals(5, $typeIndexCount);
    }
}
