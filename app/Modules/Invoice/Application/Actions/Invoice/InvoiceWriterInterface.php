<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Invoice;

use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeRequestDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;

interface InvoiceWriterInterface
{
    public function approveInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto;

    public function rejectInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto;
}
