<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api\Dto;

use App\Infrastructure\Dto\BaseDto;

class InvoiceStatusChangeRequestDto extends BaseDto
{
    /**
     * @param string $id
     */
    public function __construct(
        protected string $id,
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
}
