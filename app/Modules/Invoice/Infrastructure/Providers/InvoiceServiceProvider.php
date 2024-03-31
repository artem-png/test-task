<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Providers;

use App\Modules\Invoice\Api\InvoiceFacadeInterface;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceApproval;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceApprovalInterface;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceReader;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceReaderInterface;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceWriter;
use App\Modules\Invoice\Application\Actions\Invoice\InvoiceWriterInterface;
use App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilder;
use App\Modules\Invoice\Application\Actions\Response\InvoiceStatusChangeResponseBuilderInterface;
use App\Modules\Invoice\Application\InvoiceFacade;
use App\Modules\Invoice\Application\Persistence\EntityManager\InvoiceEntityManager;
use App\Modules\Invoice\Application\Persistence\EntityManager\InvoiceEntityManagerInterface;
use App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepository;
use App\Modules\Invoice\Application\Persistence\Repository\InvoiceRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(InvoiceApprovalInterface::class, InvoiceApproval::class);
        $this->app->bind(InvoiceReaderInterface::class, InvoiceReader::class);
        $this->app->bind(InvoiceWriterInterface::class, InvoiceWriter::class);
        $this->app->bind(InvoiceStatusChangeResponseBuilderInterface::class, InvoiceStatusChangeResponseBuilder::class);
        $this->app->bind(InvoiceEntityManagerInterface::class, InvoiceEntityManager::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);

        $this->app->scoped(InvoiceFacadeInterface::class, InvoiceFacade::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoiceFacadeInterface::class,
        ];
    }
}
