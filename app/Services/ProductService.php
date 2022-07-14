<?php

namespace App\Services;

use App\Interfaces\{
    ProductServiceInterface,
    ProductRepositoryInterface
};

class ProductService implements ProductServiceInterface
{
    public function __construct(public ProductRepositoryInterface $productRepository)
    {

    }

    public function getListPaginate(array $query_params)
    {
        return $this->productRepository->getPaginate($query_params);
    }

    public function getProduct(int $id)
    {
        return $this->productRepository->getById($id);
    }
}
