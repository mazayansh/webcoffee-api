<?php

namespace Tests\Unit\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\TypeRepository;
use App\Services\TypeService;
use App\Models\Type;

class TypeServiceTest extends TestCase
{
    use RefreshDatabase;

    private TypeService $typeService;

    public function setUp(): void
    {
        parent::setUp();

        $this->typeService = new TypeService(new TypeRepository);
    }

    public function test_get_list_success()
    {
        Type::factory(5)->create();

        $typeListCount = $this->typeService->getList()->count();

        $this->assertEquals(5, $typeListCount);
    }
}
