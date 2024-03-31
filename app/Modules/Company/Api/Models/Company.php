<?php

declare(strict_types=1);

namespace App\Modules\Company\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $street
 * @property string $city
 * @property string $zip
 * @property string $phone
 * @property string $email
 */
class Company extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'street',
        'city',
        'zip',
        'phone',
        'email',
    ];
}
