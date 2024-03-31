<?php

declare(strict_types=1);

namespace Tests\Feature\Invoice;

use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;
use App\Modules\Invoice\Api\InvoiceFacadeInterface;
use Tests\Helpers\CompanyHelper;
use Tests\Helpers\InvoiceHelper;
use Tests\TestCase;

/**
 * @group Invoice
 * @group Facade
 * @group FindInvoiceFacadeTest
 */
class FindInvoiceFacadeTest extends TestCase
{
    protected const UNKNOWN_INVOICE_ID = '0';

    /**
     * @var \Tests\Helpers\InvoiceHelper
     */
    protected InvoiceHelper $invoiceHelper;

    /**
     * @var \Tests\Helpers\CompanyHelper
     */
    protected CompanyHelper $companyHelper;

    public function __construct()
    {
        parent::__construct();

        $this->invoiceHelper = new InvoiceHelper();
        $this->companyHelper = new CompanyHelper();
    }

    public function testFilterInvoiceByIdsReturnsInvoice(): void
    {
        // Arrange
        $invoiceFacade = $this->getFacade();
        $company = $this->companyHelper->createCompany([]);
        $invoice = $this->invoiceHelper->createInvoice([
            'company_id' => $company->id,
            'billed_company_id' => $company->id,
        ]);
        $invoiceFilterDto = new InvoiceFilterDto([$invoice->id]);

        // Act
        $invoiceDto = $invoiceFacade->findInvoice($invoiceFilterDto);

        // Assert
        $this->assertNotNull($invoiceDto);
        $this->assertSame($invoice->id, $invoiceDto->getId());
        $this->assertSame($company->id, $invoiceDto->getCompany()->getId());
        $this->assertSame($company->id, $invoiceDto->getBilledCompany()->getId());
        // TODO: check totals
    }

    public function testFilterInvoiceByInvalidIdsReturnsNull(): void
    {
        // Arrange
        $invoiceFacade = $this->getFacade();
        $company = $this->companyHelper->createCompany([]);
        $invoice = $this->invoiceHelper->createInvoice([
            'company_id' => $company->id,
            'billed_company_id' => $company->id,
        ]);
        $invoiceFilterDto = new InvoiceFilterDto([static::UNKNOWN_INVOICE_ID]);

        // Act
        $invoiceDto = $invoiceFacade->findInvoice($invoiceFilterDto);

        // Assert
        $this->assertNull($invoiceDto);
    }

    protected function getFacade(): InvoiceFacadeInterface
    {
        return $this->app->make(InvoiceFacadeInterface::class);
    }
}
