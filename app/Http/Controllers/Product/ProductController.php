<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
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

    public function show($id)
    {
        try {
            $product = $this->productService->getProduct((int)$id);
            return new ProductResource($product);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }

}
