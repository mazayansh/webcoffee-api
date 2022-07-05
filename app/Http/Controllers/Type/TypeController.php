<?php

namespace App\Http\Controllers\Type;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Models\Type;

class TypeController extends Controller
{
    public function index()
    {
        return TypeResource::collection(Type::all());
    }
}
