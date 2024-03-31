<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeRequestDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;

interface InvoiceFacadeInterface
{
    /**
     * Specification:
     * - Returns invoice based on the provided criteria.
     * - Returns null if not found.
     */
    public function findInvoice(InvoiceFilterDto $invoiceFilterDto): ?InvoiceDto;

    /**
     * Specification:
     * - Updates the status of invoice in case the approval is allowed.
     * - Returns the error in case the approval is not allowed.
     */
    public function approveInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto;

    /**
     * Specification:
     * - Updates the status of invoice in case the rejection is allowed.
     * - Returns the error in case the rejection is not allowed.
     */
    public function rejectInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto;
}
