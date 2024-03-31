<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Invoice;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoice\Api\Dto\InvoiceDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;
use App\Modules\Invoice\Api\Models\Invoice;
use App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilderInterface;
use App\Modules\Invoice\Infrastructure\InvoiceConfig;
use App\Modules\Invoice\Infrastructure\InvoiceDependencyProvider;
use LogicException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

// Adapter for Approval module
class InvoiceApproval implements InvoiceApprovalInterface
{
    /**
     * @var \App\Modules\Invoice\Infrastructure\InvoiceDependencyProvider
     */
    protected InvoiceDependencyProvider $invoiceDependencyProvider;

    /**
     * @var \App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilderInterface
     */
    protected InvoiceStatusChangeResponseBuilderInterface $invoiceStatusChangeResponseBuilder;

    /**
     * @param \App\Modules\Invoice\Infrastructure\InvoiceDependencyProvider $invoiceDependencyProvider
     * @param \App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilderInterface $invoiceStatusChangeResponseBuilder
     */
    public function __construct(
        InvoiceDependencyProvider $invoiceDependencyProvider,
        InvoiceStatusChangeResponseBuilderInterface $invoiceStatusChangeResponseBuilder,
    ) {
        $this->invoiceDependencyProvider = $invoiceDependencyProvider;
        $this->invoiceStatusChangeResponseBuilder = $invoiceStatusChangeResponseBuilder;
    }

    public function approveInvoice(InvoiceDto $invoiceDto): InvoiceStatusChangeResponseDto
    {
        $approvalDto = new ApprovalDto(
            $this->convertStringIdToUuid($invoiceDto->getId()),
            $invoiceDto->getStatus(),
            Invoice::class
        );

        try {
            $result = $this->invoiceDependencyProvider->getApprovalFacade()->approve($approvalDto);
        } catch (LogicException $logicException) {
            return $this->invoiceStatusChangeResponseBuilder
                ->createErrorResponse($invoiceDto, $logicException->getMessage());
        }

        if (!$result) {
            return $this->invoiceStatusChangeResponseBuilder
                ->createErrorResponse($invoiceDto, InvoiceConfig::ERROR_STATUS_CAN_NOT_BE_UPDATED);
        }

        return $this->invoiceStatusChangeResponseBuilder->createSuccessfulResponse($invoiceDto);
    }

    public function rejectInvoice(InvoiceDto $invoiceDto): InvoiceStatusChangeResponseDto
    {
        $approvalDto = new ApprovalDto(
            $this->convertStringIdToUuid($invoiceDto->getId()),
            $invoiceDto->getStatus(),
            Invoice::class
        );

        try {
            $result = $this->invoiceDependencyProvider->getApprovalFacade()->reject($approvalDto);
        } catch (LogicException $logicException) {
            return $this->invoiceStatusChangeResponseBuilder
                ->createErrorResponse($invoiceDto, $logicException->getMessage());
        }

        if (!$result) {
            return $this->invoiceStatusChangeResponseBuilder
                ->createErrorResponse($invoiceDto, InvoiceConfig::ERROR_STATUS_CAN_NOT_BE_UPDATED);
        }

        return $this->invoiceStatusChangeResponseBuilder->createSuccessfulResponse($invoiceDto);
    }

    protected function convertStringIdToUuid(string $id): UuidInterface
    {
        return Uuid::fromString($id);
    }
}
