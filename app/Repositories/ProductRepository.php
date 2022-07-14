<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getPaginate(array $query_params)
    {
        return Product::joinProductVariant()
                    ->sortProduct($query_params['sort'] ?? null)
                    ->searchProduct($query_params['search'] ?? null)
                    ->filterProduct($query_params['filter'] ?? null)
                    ->paginate(20);
    }
}
