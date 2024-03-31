<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Persistence\Mapper;

use App\Modules\Invoice\Api\Dto\InvoiceProductLineDto;
use App\Modules\Invoice\Api\Models\InvoiceProductLine;

class InvoiceProductLineMapper
{
    /**
     * @param list<\App\Modules\Invoice\Api\Models\InvoiceProductLine> $invoiceLineProducts
     *
     * @return list<\App\Modules\Invoice\Api\Dto\InvoiceProductLineDto>
     */
    public function mapInvoiceProductLineEntitiesToInvoiceProductLineDtoCollection(array $invoiceProductLines): array
    {
        $invoiceProductLineDtos = [];

        foreach ($invoiceProductLines as $invoiceProductLine) {
            $invoiceProductLineDtos[] = $this->mapInvoiceProductLineEntityToInvoiceProductLineDto($invoiceProductLine);
        }

        return $invoiceProductLineDtos;
    }

    public function mapInvoiceProductLineEntityToInvoiceProductLineDto(
        InvoiceProductLine $invoiceProductLine
    ): InvoiceProductLineDto {
        return new InvoiceProductLineDto(
            $invoiceProductLine->product->name,
            $invoiceProductLine->quantity,
            $invoiceProductLine->product->price,
            null,
        );
    }
}
