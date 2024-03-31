<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Persistence\Repository;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;
use App\Modules\Invoice\Api\Models\Invoice;
use App\Modules\Invoice\Application\Persistence\Mapper\InvoiceMapper;
use Illuminate\Database\Eloquent\Builder;

class InvoiceRepository implements InvoiceRepositoryInterface
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

    public function findInvoice(InvoiceFilterDto $invoiceFilterDto): ?InvoiceDto
    {
        $invoiceQuery = Invoice::query()->with('company', 'billedCompany', 'invoiceProductLines');
        // I assume that Invoice module fully depends on company and products, as it has this data inside its table.
        // Ideally is to have some expander which will expand the invoice DTO with products and companies.
        $invoiceQuery = $this->applyFilter($invoiceQuery, $invoiceFilterDto);

        /** @var \App\Modules\Invoice\Api\Models\Invoice|null $invoiceEntity */
        $invoiceEntity = $invoiceQuery->first();

        if (!$invoiceEntity) {
            return null;
        }

        return $this->invoiceMapper->mapInvoiceEntityToInvoiceDto($invoiceEntity);
    }

    protected function applyFilter(Builder $builder, InvoiceFilterDto $invoiceFilterDto): Builder
    {
        if ($invoiceFilterDto->getIds()) {
            $builder->whereIn('id', $invoiceFilterDto->getIds());
        }

        return $builder;
    }
}
