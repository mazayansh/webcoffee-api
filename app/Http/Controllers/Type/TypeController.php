<?php

namespace App\Http\Controllers\Type;

use App\Http\Controllers\Controller;
use App\Interfaces\TypeServiceInterface;
use App\Http\Resources\TypeResource;
use App\Models\Type;

class TypeController extends Controller
{
    public function __construct(public TypeServiceInterface $typeService)
    {

    }

    public function index()
    {
        return TypeResource::collection($this->typeService->getList());
    }
}
