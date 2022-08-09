<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getPaginate(array $queryParams)
    {
        return Product::joinProductVariant()
                    ->withFeaturedImage()
                    ->sortProduct($queryParams['sort'] ?? null)
                    ->searchProduct($queryParams['search'] ?? null)
                    ->filterProduct($queryParams['filter'] ?? null)
                    ->paginate(20);
    }

    public function getById(int $id)
    {
        return Product::findOrFail($id)->load(['roast','type','productVariants','medias']);
    }
}
