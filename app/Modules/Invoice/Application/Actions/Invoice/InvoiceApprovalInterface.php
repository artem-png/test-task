<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Invoice;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;

interface InvoiceApprovalInterface
{
    public function approveInvoice(InvoiceDto $invoiceDto): InvoiceStatusChangeResponseDto;

    public function rejectInvoice(InvoiceDto $invoiceDto): InvoiceStatusChangeResponseDto;
}
