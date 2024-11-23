<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll()
    {
        return Category::orderBy('created_at', 'desc')->get();
    }

    public function getByCompany($companyId)
    {
        return Category::orderBy('created_at', 'desc')
            ->where('company_id', $companyId)
            ->get();
    }

    public function findById($id)
    {
        return Category::find($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->findById($id);
        if ($category && $category->company_id === request()->user()->company_id) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function delete($id)
    {
        $category = $this->findById($id);
        if ($category && $category->company_id === request()->user()->company_id) {
            $category->delete();
            return true;
        }
        return false;
    }
}
