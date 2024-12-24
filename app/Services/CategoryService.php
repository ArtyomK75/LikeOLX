<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryService
{
    private CategoryRepository $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->index();
        return response()->json($categories);
    }

    public function store(Request $request) {

        if (auth()->user()->cannot('store', Category::class)) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        $data = $request->validate(['name' => 'sometimes|string|max:50']);
        $newCategory = $this->categoryRepository->store($data);
        return response()->json($newCategory);
    }

    public function show($id)
    {
        return response()->json($this->categoryRepository->show($id));
    }

    public function update(Request $request, Category $category)
    {
        if (auth()->user()->cannot('update', $category)) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        if (!$category) {
            throw new ModelNotFoundException("Advert with ID {$request->id} not found.");
        }

        return response()->json($this->categoryRepository->update($request->except('_token'), $category));

    }
}
