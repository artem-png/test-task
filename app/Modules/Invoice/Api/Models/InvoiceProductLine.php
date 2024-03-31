<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Api\Models;

use App\Modules\Product\Api\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $invoice_id
 * @property string $product_id
 * @property int $quantity
 * @property \App\Modules\Invoice\Api\Models\Invoice $invoice
 * @property \App\Modules\Product\Api\Models\Product $product
 */
class InvoiceProductLine extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
