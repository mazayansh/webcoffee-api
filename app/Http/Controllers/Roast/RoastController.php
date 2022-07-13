<?php

namespace App\Http\Controllers\Roast;

use App\Http\Controllers\Controller;
use App\Interfaces\RoastServiceInterface;
use App\Http\Resources\RoastResource;

class RoastController extends Controller
{
    public function __construct(public RoastServiceInterface $roastService)
    {

    }

    public function index()
    {
        $roasts = $this->roastService->getList();

        return RoastResource::collection($roasts);
    }
}
