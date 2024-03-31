<?php

declare(strict_types=1);

namespace Tests\Helpers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Models\Invoice;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

/**
 * @group Invoice
 * @group Facade
 */
class InvoiceHelper extends TestCase
{
    public function createInvoice(array $data): Invoice
    {
        $defaultData = [
            'status' => StatusEnum::DRAFT,
            'number' => uniqid(),
            'date' => date('Y-m-d'),
            'due_date' => date('Y-m-d'),
        ];
        $data = array_merge($defaultData, $data);
        $invoice = new Invoice($data);
        $invoice->id = Uuid::uuid4()->toString();
        $invoice->save();

        return $invoice;
    }
}
