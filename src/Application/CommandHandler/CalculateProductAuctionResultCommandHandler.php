<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\CalculateProductAuctionResultCommand;
use App\Application\Exception\Product\ProductNotFoundException;
use App\Domain\Model\Product\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @author Jared Barber
 */
#[AsMessageHandler(bus: 'commands.bus')]
final class CalculateProductAuctionResultCommandHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    /**
     * @throws ProductNotFoundException
     */
    public function __invoke(CalculateProductAuctionResultCommand $command): void
    {
        $product = $this->productRepository->findByIdOrFail($command->productId);
        $product->calculateAuctionResult();
        $this->productRepository->save($product);
    }
}
