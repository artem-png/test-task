<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api\Dto;

use App\Domain\Enums\StatusEnum;
use App\Infrastructure\Dto\BaseDto;
use App\Modules\Company\Api\Dto\CompanyDto;

class InvoiceDto extends BaseDto
{
    /**
     * @param string $id
     * @param \App\Domain\Enums\StatusEnum $status
     * @param string $number
     * @param string $date
     * @param string $dueDate
     * @param int|null $totalPrice
     * @param \App\Modules\Company\Api\Dto\CompanyDto $company
     * @param \App\Modules\Company\Api\Dto\CompanyDto $billedCompany
     * @param list<\App\Modules\Invoice\Api\Dto\InvoiceProductLineDto> $products
     */
    public function __construct(
        protected string $id,
        protected StatusEnum $status,
        protected string $number,
        protected string $date,
        protected string $dueDate,
        protected ?int $totalPrice,
        protected CompanyDto $company,
        protected CompanyDto $billedCompany,
        protected array $products,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return \App\Modules\Invoice\Api\Dto\InvoiceProductLineDto[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getCompany(): CompanyDto
    {
        return $this->company;
    }

    public function setCompany(CompanyDto $company): void
    {
        $this->company = $company;
    }

    public function getBilledCompany(): CompanyDto
    {
        return $this->billedCompany;
    }

    public function setBilledCompany(CompanyDto $billedCompany): void
    {
        $this->billedCompany = $billedCompany;
    }
}
