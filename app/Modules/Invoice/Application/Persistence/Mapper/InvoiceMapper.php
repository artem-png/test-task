<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Persistence\Mapper;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Models\Invoice;

class InvoiceMapper
{
    /**
     * @var \App\Modules\Invoice\Application\Persistence\Mapper\CompanyMapper
     */
    protected CompanyMapper $companyMapper;

    /**
     * @var \App\Modules\Invoice\Application\Persistence\Mapper\InvoiceProductLineMapper
     */
    protected InvoiceProductLineMapper $invoiceProductLineMapper;

    /**
     * @param \App\Modules\Invoice\Application\Persistence\Mapper\CompanyMapper $companyMapper
     * @param \App\Modules\Invoice\Application\Persistence\Mapper\InvoiceProductLineMapper $invoiceProductLineMapper
     */
    public function __construct(
        CompanyMapper $companyMapper,
        InvoiceProductLineMapper $invoiceProductLineMapper,
    ) {
        $this->companyMapper = $companyMapper;
        $this->invoiceProductLineMapper = $invoiceProductLineMapper;
    }

    public function mapInvoiceEntityToInvoiceDto(Invoice $invoice): InvoiceDto
    {
        return new InvoiceDto(
            $invoice->id,
            StatusEnum::from($invoice->status),
            $invoice->number,
            $invoice->date,
            $invoice->due_date,
            null,
            $this->companyMapper->mapCompanyEntityToCompanyDto($invoice->company),
            $this->companyMapper->mapCompanyEntityToCompanyDto($invoice->billedCompany),
            $this->invoiceProductLineMapper->mapInvoiceProductLineEntitiesToInvoiceProductLineDtoCollection(
                $invoice->invoiceProductLines->all(),
            ),
        );
    }

    public function mapInvoiceDtoToInvoiceEntity(InvoiceDto $invoiceDto, Invoice $invoice): Invoice
    {
        $invoice->fill(array_filter($invoiceDto->toArray()));

        return $invoice;
    }
}
