<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function getAllCategoriesByCompany()
    {
        return $this->categoryRepository->getByCompany(request()->user()->company_id);
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $data)
    {
        // Contoh logika bisnis: memvalidasi nama unik
        if ($this->categoryRepository->getByCompany(request()->user()->company_id)->where('name', $data['name'])->isNotEmpty()) {
            throw new \Exception('Category name already exists.');
        }

        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
