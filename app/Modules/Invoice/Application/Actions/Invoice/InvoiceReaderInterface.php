<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Invoice;

use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;

interface InvoiceReaderInterface
{
    public function findInvoice(InvoiceFilterDto $invoiceFilterDto): ?InvoiceDto;
}
