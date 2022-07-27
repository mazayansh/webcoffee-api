<?php

namespace Tests\Unit\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\RoastRepository;
use App\Services\RoastService;
use App\Models\Roast;

class RoastServiceTest extends TestCase
{
    use RefreshDatabase;

    private RoastService $roastService;

    public function setUp(): void
    {
        parent::setUp();

        $this->roastService = new RoastService(new RoastRepository);
    }

    public function test_get_list_success()
    {
        Roast::factory(5)->create();

        $roastListCount = $this->roastService->getList()->count();

        $this->assertEquals(5, $roastListCount);
    }
}
