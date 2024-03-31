<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Persistence\EntityManager;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Models\Invoice;
use App\Modules\Invoice\Application\Persistence\Mapper\InvoiceMapper;

class InvoiceEntityManager implements InvoiceEntityManagerInterface
{
    /**
     * @var \App\Modules\Invoice\Application\Persistence\Mapper\InvoiceMapper
     */
    protected InvoiceMapper $invoiceMapper;

    /**
     * @param \App\Modules\Invoice\Application\Persistence\Mapper\InvoiceMapper $invoiceMapper
     */
    public function __construct(InvoiceMapper $invoiceMapper)
    {
        $this->invoiceMapper = $invoiceMapper;
    }

    public function updateInvoice(InvoiceDto $invoiceDto): InvoiceDto
    {
        /** @var \App\Modules\Invoice\Api\Models\Invoice $invoiceEntity */
        $invoiceEntity = Invoice::query()->where('id', $invoiceDto->getId())->first();

        $invoiceEntity = $this->invoiceMapper->mapInvoiceDtoToInvoiceEntity($invoiceDto, $invoiceEntity);
        $invoiceEntity->save();

        return $invoiceDto;
    }
}
