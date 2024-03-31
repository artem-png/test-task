<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeRequestDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;
use App\Modules\Invoice\Api\InvoiceFacadeInterface;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceReaderInterface;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceWriterInterface;

class InvoiceFacade implements InvoiceFacadeInterface
{
    /**
     * @var \App\Modules\Invoice\Application\Actions\Invoice\InvoiceWriterInterface
     */
    protected InvoiceWriterInterface $invoiceWriter;

    /**
     * @var \App\Modules\Invoice\Application\Actions\Invoice\InvoiceReaderInterface
     */
    protected InvoiceReaderInterface $invoiceReader;

    /**
     * @param \App\Modules\Invoice\Application\Actions\Invoice\InvoiceWriterInterface $invoiceWriter
     * @param \App\Modules\Invoice\Application\Actions\Invoice\InvoiceReaderInterface $invoiceReader
     */
    public function __construct(
        InvoiceWriterInterface $invoiceWriter,
        InvoiceReaderInterface $invoiceReader,
    ) {
        $this->invoiceWriter = $invoiceWriter;
        $this->invoiceReader = $invoiceReader;
    }

    public function findInvoice(InvoiceFilterDto $invoiceFilterDto): ?InvoiceDto
    {
        return $this->invoiceReader->findInvoice($invoiceFilterDto);
    }

    public function approveInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto {
        return $this->invoiceWriter->approveInvoice($invoiceStatusChangeRequestDto);
    }

    public function rejectInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto {
        return $this->invoiceWriter->rejectInvoice($invoiceStatusChangeRequestDto);
    }
}
