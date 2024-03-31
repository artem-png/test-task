<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Response;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;

interface InvoiceStatusChangeResponseBuilderInterface
{
    public function createErrorResponse(?InvoiceDto $invoiceDto, string $message): InvoiceStatusChangeResponseDto;

    public function createSuccessfulResponse(InvoiceDto $invoiceDto): InvoiceStatusChangeResponseDto;
}
