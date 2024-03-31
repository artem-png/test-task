<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api\Dto;

use App\Infrastructure\Dto\BaseDto;

class InvoiceProductLineDto extends BaseDto
{
    /**
     * @param string $name
     * @param int $quantity
     * @param int $unitPrice
     * @param int|null $total
     */
    public function __construct(
        protected string $name,
        protected int $quantity,
        protected int $unitPrice,
        protected ?int $total,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }
}
