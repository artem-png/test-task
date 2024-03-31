<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Http\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoice\Api\Dto\InvoiceFilterDto;
use App\Modules\Invoice\Api\Dto\InvoiceStatusChangeRequestDto;
use App\Modules\Invoice\Api\InvoiceFacadeInterface;
use App\Modules\Invoice\Application\Http\Requests\ApproveInvoiceRequest;
use App\Modules\Invoice\Application\Http\Requests\GetOneInvoiceRequest;
use App\Modules\Invoice\Application\Http\Requests\RejectInvoiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * @var \App\Modules\Invoice\Api\InvoiceFacadeInterface
     */
    protected InvoiceFacadeInterface $invoiceFacade;

    /**
     * @param \App\Modules\Invoice\Api\InvoiceFacadeInterface $invoiceFacade
     */
    public function __construct(InvoiceFacadeInterface $invoiceFacade)
    {
        $this->invoiceFacade = $invoiceFacade;
    }

    public function getOne(GetOneInvoiceRequest $getOneInvoiceRequest): JsonResponse
    {
        $invoiceFilterDto = new InvoiceFilterDto([$getOneInvoiceRequest->get('id')]);
        $invoiceDto = $this->invoiceFacade->findInvoice($invoiceFilterDto);

        if (!$invoiceDto) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($invoiceDto->toArray(), Response::HTTP_OK);
    }

    public function approveInvoice(ApproveInvoiceRequest $approveInvoiceRequest): JsonResponse
    {
        $invoiceStatusChangeRequestDto = new InvoiceStatusChangeRequestDto($approveInvoiceRequest->get('id'));
        $invoiceStatusChangeResponseDto = $this->invoiceFacade->approveInvoice($invoiceStatusChangeRequestDto);

        if (!$invoiceStatusChangeResponseDto->isSuccessful()) {
            return new JsonResponse($invoiceStatusChangeResponseDto->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $invoiceFilterDto = new InvoiceFilterDto([$approveInvoiceRequest->get('id')]);
        $invoiceDto = $this->invoiceFacade->findInvoice($invoiceFilterDto);

        return new JsonResponse($invoiceDto->toArray(), Response::HTTP_OK);
    }

    public function rejectInvoice(RejectInvoiceRequest $rejectInvoiceRequest): JsonResponse
    {
        $invoiceStatusChangeRequestDto = new InvoiceStatusChangeRequestDto($rejectInvoiceRequest->get('id'));
        $invoiceStatusChangeResponseDto = $this->invoiceFacade->rejectInvoice($invoiceStatusChangeRequestDto);

        if (!$invoiceStatusChangeResponseDto->isSuccessful()) {
            return new JsonResponse($invoiceStatusChangeResponseDto->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $invoiceFilterDto = new InvoiceFilterDto([$rejectInvoiceRequest->get('id')]);
        $invoiceDto = $this->invoiceFacade->findInvoice($invoiceFilterDto);

        return new JsonResponse($invoiceDto->toArray(), Response::HTTP_OK);
    }
}
