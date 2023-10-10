<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;

use App\Domain\Model\Product\Exception\ProductNotFoundException;
use Symfony\Component\Uid\Uuid;

/**
 * @author Jared Barber
 */
interface ProductRepositoryInterface
{
    /**
     * Find aa Product by its id or throw an exception if does not exist.
     *
     * @param Uuid $productId
     *
     * @return Product
     * @throws ProductNotFoundException
     */
    public function findByIdOrFail(Uuid $productId): Product;

    /**
     * Saves the Product changes
     *
     * @param Product $product
     * @return void
     */
    public function save(Product $product): void;
}