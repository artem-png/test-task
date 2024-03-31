<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Persistence\EntityManager;

use App\Modules\Invoice\Api\Dto\InvoiceDto;

interface InvoiceEntityManagerInterface
{
    public function updateInvoice(InvoiceDto $invoiceDto): InvoiceDto;
}
