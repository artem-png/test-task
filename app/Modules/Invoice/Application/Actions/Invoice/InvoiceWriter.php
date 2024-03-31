<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions\Invoice;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeRequestDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeResponseDto;
use App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilderInterface;
use App\Modules\Invoice\Application\Persistence\EntityManager\InvoiceEntityManagerInterface;
use App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepositoryInterface;
use App\Modules\Invoice\Infrastructure\InvoiceConfig;

class InvoiceWriter implements InvoiceWriterInterface
{
    /**
     * @var \App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepositoryInterface
     */
    protected InvoiceRepositoryInterface $invoiceRepository;

    /**
     * @var \App\Modules\Invoice\Application\Persistence\EntityManager\InvoiceEntityManagerInterface
     */
    protected InvoiceEntityManagerInterface $invoiceEntityManager;

    /**
     * @var \App\Modules\Invoice\Application\Actions\Invoice\InvoiceApprovalInterface
     */
    protected InvoiceApprovalInterface $invoiceApproval;

    /**
     * @var \App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilderInterface
     */
    protected InvoiceStatusChangeResponseBuilderInterface $invoiceStatusChangeResponseBuilder;

    /**
     * @param \App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepositoryInterface $invoiceRepository
     * @param \App\Modules\Invoice\Application\Persistence\EntityManager\InvoiceEntityManagerInterface $invoiceEntityManager
     * @param \App\Modules\Invoice\Application\Actions\Invoice\InvoiceApprovalInterface $invoiceApproval
     * @param \App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilderInterface $invoiceStatusChangeResponseBuilder
     */
    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        InvoiceEntityManagerInterface $invoiceEntityManager,
        InvoiceApprovalInterface $invoiceApproval,
        InvoiceStatusChangeResponseBuilderInterface $invoiceStatusChangeResponseBuilder,
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceEntityManager = $invoiceEntityManager;
        $this->invoiceApproval = $invoiceApproval;
        $this->invoiceStatusChangeResponseBuilder = $invoiceStatusChangeResponseBuilder;
    }

    public function approveInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto {
        $invoiceDto = $this->invoiceRepository->findInvoice(
            new InvoiceFilterDto([$invoiceStatusChangeRequestDto->getId()]),
        );

        if (!$invoiceDto) {
            return $this->invoiceStatusChangeResponseBuilder
                ->createErrorResponse($invoiceDto, InvoiceConfig::ERROR_INVOICE_NOT_FOUND);
        }

        $invoiceStatusChangeResponseDto = $this->invoiceApproval->approveInvoice($invoiceDto);

        if (!$invoiceStatusChangeResponseDto->isSuccessful()) {
            return $invoiceStatusChangeResponseDto;
        }

        $invoiceDto->setStatus(StatusEnum::APPROVED);
        $this->invoiceEntityManager->updateInvoice($invoiceDto);

        return $this->invoiceStatusChangeResponseBuilder->createSuccessfulResponse($invoiceDto);
    }

    public function rejectInvoice(
        InvoiceStatusChangeRequestDto $invoiceStatusChangeRequestDto,
    ): InvoiceStatusChangeResponseDto {
        $invoiceDto = $this->invoiceRepository->findInvoice(
            new InvoiceFilterDto([$invoiceStatusChangeRequestDto->getId()]),
        );

        if (!$invoiceDto) {
            return $this->invoiceStatusChangeResponseBuilder
                ->createErrorResponse($invoiceDto, InvoiceConfig::ERROR_INVOICE_NOT_FOUND);
        }

        $invoiceStatusChangeResponseDto = $this->invoiceApproval->rejectInvoice($invoiceDto);

        if (!$invoiceStatusChangeResponseDto->isSuccessful()) {
            return $invoiceStatusChangeResponseDto;
        }

        $invoiceDto->setStatus(StatusEnum::REJECTED);
        $this->invoiceEntityManager->updateInvoice($invoiceDto);

        return $this->invoiceStatusChangeResponseBuilder->createSuccessfulResponse($invoiceDto);
    }
}
