<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use App\Interfaces\ProductServiceInterface;

class ProductController extends Controller
{
    public function __construct(public ProductServiceInterface $productService)
    {

    }

    public function index(Request $request)
    {
        $products = $this->productService->getListPaginate($request->query());

        return new ProductCollection($products);
    }

}
