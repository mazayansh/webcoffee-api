<?php

namespace Tests\Unit\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\RoastRepository;
use App\Models\Roast;

class RoastRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private RoastRepository $roastRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->roastRepository = new RoastRepository();
    }

    public function test_get_roast_index_success()
    {
        Roast::factory(5)->create();

        $roastIndexCount = Roast::all()->count();

        $this->assertEquals(5, $roastIndexCount);
    }
}
