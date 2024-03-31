<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Persistence\Mapper;

use App\Modules\Company\Api\Dto\CompanyDto;
use App\Modules\Company\Api\Models\Company;

class CompanyMapper
{
    public function mapCompanyEntityToCompanyDto(Company $company): CompanyDto
    {
        return new CompanyDto(
            $company->id,
            $company->name,
            $company->street,
            $company->city,
            $company->zip,
            $company->phone,
            $company->email,
        );
    }
}
