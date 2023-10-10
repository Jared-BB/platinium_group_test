<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Product;

use App\Domain\Model\Product\Exception\ProductNotFoundException;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @author Jared Barber
 */
class MysqlProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @inheritDoc
     */
    public function findByIdOrFail(Uuid $productId): Product
    {
        $product = $this->find($productId);

        if ($product === null) {
            throw ProductNotFoundException::becauseDoesNotExists($productId);
        }

        return $product;
    }

    /**
     * @inheritDoc
     */
    public function save(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }
}