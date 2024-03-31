<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Persistence\Repository;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;

interface InvoiceRepositoryInterface
{
    public function findInvoice(InvoiceFilterDto $invoiceFilterDto): ?InvoiceDto;
}
