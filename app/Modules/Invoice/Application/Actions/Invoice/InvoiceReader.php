<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Invoice;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;
use App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepositoryInterface;

class InvoiceReader implements InvoiceReaderInterface
{
    /**
     * @var \App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepositoryInterface
     */
    protected InvoiceRepositoryInterface $invoiceRepository;

    /**
     * @param \App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepositoryInterface $invoiceRepository
     */
    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function findInvoice(InvoiceFilterDto $invoiceFilterDto): ?InvoiceDto
    {
        $invoiceDto = $this->invoiceRepository->findInvoice($invoiceFilterDto);

        if (!$invoiceDto) {
            return null;
        }

        return $this->expandWithTotalPrices($invoiceDto);
    }

    protected function expandWithTotalPrices(InvoiceDto $invoiceDto): InvoiceDto
    {
        $totalPrice = 0;

        foreach ($invoiceDto->getProducts() as $invoiceProductLineDto) {
            $invoiceProductLineDto->setTotal(
                $invoiceProductLineDto->getQuantity() * $invoiceProductLineDto->getUnitPrice()
            );
            $totalPrice += $invoiceProductLineDto->getTotal();
        }

        $invoiceDto->setTotalPrice($totalPrice);

        return $invoiceDto;
    }
}
