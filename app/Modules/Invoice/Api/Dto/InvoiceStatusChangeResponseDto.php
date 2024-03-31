<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api\Dto;

use App\Infrastructure\Dto\BaseDto;

class InvoiceStatusChangeResponseDto extends BaseDto
{
    /**
     * @param \App\Modules\Invoice\Api\Dto\InvoiceDto|null $invoice
     * @param bool $isSuccessful
     * @param array<string> $errors
     */
    public function __construct(
        protected ?InvoiceDto $invoice,
        protected bool $isSuccessful,
        protected array $errors,
    ) {
    }

    public function setInvoice(?InvoiceDto $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getInvoice(): ?InvoiceDto
    {
        return $this->invoice;
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    public function setIsSuccessful(bool $isSuccessful): void
    {
        $this->isSuccessful = $isSuccessful;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
