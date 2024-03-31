<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure;

use App\Modules\Approval\Api\ApprovalFacadeInterface;

class InvoiceDependencyProvider
{
    /**
     * @var \App\Modules\Approval\Api\ApprovalFacadeInterface
     */
    protected ApprovalFacadeInterface $approvalFacade;

    /**
     * @param \App\Modules\Approval\Api\ApprovalFacadeInterface $approvalFacade
     */
    public function __construct(ApprovalFacadeInterface $approvalFacade)
    {
        $this->approvalFacade = $approvalFacade;
    }

    public function getApprovalFacade(): ApprovalFacadeInterface
    {
        return $this->approvalFacade;
    }
}
