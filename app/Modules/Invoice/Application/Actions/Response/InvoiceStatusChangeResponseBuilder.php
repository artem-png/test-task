<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Response;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;

class InvoiceStatusChangeResponseBuilder implements InvoiceStatusChangeResponseBuilderInterface
{
    public function createErrorResponse(?InvoiceDto $invoiceDto, string $message): InvoiceStatusChangeResponseDto
    {
        return new InvoiceStatusChangeResponseDto(
            $invoiceDto,
            false,
            [
                $message,
            ],
        );
    }

    public function createSuccessfulResponse(InvoiceDto $invoiceDto): InvoiceStatusChangeResponseDto
    {
        return new InvoiceStatusChangeResponseDto($invoiceDto, true, []);
    }
}
