<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function index()
    {
        return Category::orderBy('name', 'asc')
            ->paginate(20);
    }

    public function store($data) {
        return Category::create($data);
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update($data, $category) {

        return $category->update($data);
    }

}
