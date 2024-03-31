<?php

declare(strict_types=1);

namespace App\Modules\Product\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property int $price
 * @property string $currency
 */
class Product extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'price',
        'currency',
    ];
}
