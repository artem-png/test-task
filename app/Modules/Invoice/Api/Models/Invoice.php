<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api\Models;

use App\Modules\Company\Api\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $status
 * @property string $number
 * @property string $date
 * @property string $due_date
 * @property string $company_id
 * @property string $billed_company_id
 * @property \App\Modules\Company\Api\Models\Company $company
 * @property \App\Modules\Company\Api\Models\Company $billedCompany
 * @property \Illuminate\Database\Eloquent\Collection<\App\Modules\Invoice\Api\Models\InvoiceProductLine> $invoiceProductLines
 */
class Invoice extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'status',
        'number',
        'date',
        'due_date',
        'company_id',
        'billed_company_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function billedCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'billed_company_id');
    }

    public function invoiceProductLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }
}
