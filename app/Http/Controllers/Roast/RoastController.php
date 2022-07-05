<?php

namespace App\Http\Controllers\Roast;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoastResource;
use App\Models\Roast;

class RoastController extends Controller
{
    public function index()
    {
        return RoastResource::collection(Roast::all());
    }
}
