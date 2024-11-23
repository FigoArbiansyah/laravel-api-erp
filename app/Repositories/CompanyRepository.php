<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function create(array $data)
    {
        $created = Company::create($data);
        return $created;
    }
}
