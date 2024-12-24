<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    public function index()
    {
        return $this->categoryService->index();
    }

    public function store(Request $request)
    {
        return $this->categoryService->store($request);
    }

    public function show(string $id)
    {
        return $this->categoryService->show($id);
    }

    public function update(Request $request, Category $category)
    {
        return $this->categoryService->update($request, $category);
    }

}
