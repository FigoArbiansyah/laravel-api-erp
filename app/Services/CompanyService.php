<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function createCompany(array $data)
    {
        return $this->companyRepository->create($data);
    }
}