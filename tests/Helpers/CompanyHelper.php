<?php

declare(strict_types=1);

namespace Tests\Helpers;

use App\Modules\Company\Api\Models\Company;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use function Symfony\Component\String\u;

/**
 * @group Invoice
 * @group Facade
 */
class CompanyHelper extends TestCase
{
    public function createCompany(array $data): Company
    {
        $defaultData = [
            'name' => uniqid(),
            'street' => uniqid(),
            'city' => uniqid(),
            'zip' => uniqid(),
            'phone' => uniqid(),
            'email' => uniqid(),
        ];
        $data = array_merge($defaultData, $data);
        $company = new Company($data);
        $company->id = Uuid::uuid4()->toString();
        $company->save();

        return $company;
    }
}
