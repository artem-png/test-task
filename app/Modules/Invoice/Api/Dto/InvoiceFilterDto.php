<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api\Dto;

use App\Infrastructure\Dto\BaseDto;

class InvoiceFilterDto extends BaseDto
{
    /**
     * @param string[] $id
     */
    public function __construct(
        protected array $ids,
    ) {
    }

    /**
     * @return string[]
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    public function setIds(array $ids): void
    {
        $this->ids = $ids;
    }
}
