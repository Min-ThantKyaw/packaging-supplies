<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreCategoryRequest;
use App\Services\Owner\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service) {}

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->store($request->validated(), $request->user()->id);

        return response()->json($category, 201);
    }
}
