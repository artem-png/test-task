<?php

declare(strict_types=1);

namespace Tests\Feature\Invoice;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeRequestDto;
use App\Modules\Invoice\Api\InvoiceFacadeInterface;
use App\Modules\Invoice\Infrastructure\InvoiceConfig;
use Tests\Helpers\CompanyHelper;
use Tests\Helpers\InvoiceHelper;
use Tests\TestCase;

/**
 * @group Invoice
 * @group Facade
 * @group RejectInvoiceFacadeTest
 */
class RejectInvoiceFacadeTest extends TestCase
{
    protected const UNKNOWN_INVOICE_ID = '0';

    protected const ERROR_MESSAGE = 'approval status is already assigned';

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

    public function testRejectInvoiceWithStatusDraftReturnsSuccess(): void
    {
        // Arrange
        $invoiceFacade = $this->getFacade();
        $company = $this->companyHelper->createCompany([]);
        $invoice = $this->invoiceHelper->createInvoice([
            'status' => StatusEnum::DRAFT->value,
            'company_id' => $company->id,
            'billed_company_id' => $company->id,
        ]);
        $invoiceStatusChangeRequestDto = new InvoiceStatusChangeRequestDto($invoice->id);

        // Act
        $invoiceStatusChangeResponseDto = $invoiceFacade->rejectInvoice($invoiceStatusChangeRequestDto);

        // Assert
        $this->assertTrue($invoiceStatusChangeResponseDto->isSuccessful());
        $this->assertSame(StatusEnum::APPROVED->value, $invoiceStatusChangeResponseDto->getInvoice()->getStatus()->value);
    }

    public function testRejectInvoiceWithStatusRejectedReturnsError(): void
    {
        // Arrange
        $invoiceFacade = $this->getFacade();
        $company = $this->companyHelper->createCompany([]);
        $invoice = $this->invoiceHelper->createInvoice([
            'status' => StatusEnum::REJECTED->value,
            'company_id' => $company->id,
            'billed_company_id' => $company->id,
        ]);
        $invoiceStatusChangeRequestDto = new InvoiceStatusChangeRequestDto($invoice->id);

        // Act
        $invoiceStatusChangeResponseDto = $invoiceFacade->rejectInvoice($invoiceStatusChangeRequestDto);

        // Assert
        $this->assertFalse($invoiceStatusChangeResponseDto->isSuccessful());
        $this->assertSame(
            static::ERROR_MESSAGE,
            $invoiceStatusChangeResponseDto->getErrors()[0],
        );
    }

    public function testRejectInvoiceWithInvalidIdReturnsError(): void
    {
        // Arrange
        $invoiceFacade = $this->getFacade();
        $invoiceStatusChangeRequestDto = new InvoiceStatusChangeRequestDto(static::UNKNOWN_INVOICE_ID);

        // Act
        $invoiceStatusChangeResponseDto = $invoiceFacade->rejectInvoice($invoiceStatusChangeRequestDto);

        // Assert
        $this->assertFalse($invoiceStatusChangeResponseDto->isSuccessful());
        $this->assertSame(
            InvoiceConfig::ERROR_INVOICE_NOT_FOUND,
            $invoiceStatusChangeResponseDto->getErrors()[0],
        );
    }

    protected function getFacade(): InvoiceFacadeInterface
    {
        return $this->app->make(InvoiceFacadeInterface::class);
    }
}
