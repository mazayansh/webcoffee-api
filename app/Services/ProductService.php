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

    public function getListPaginate(array $queryParams)
    {
        return $this->productRepository->getPaginate($queryParams);
    }

    public function getProduct(int $id)
    {
        return $this->productRepository->getById($id);
    }
}
