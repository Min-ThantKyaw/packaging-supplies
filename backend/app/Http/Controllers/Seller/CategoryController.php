<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\StoreCategoryRequest;
use App\Services\Seller\CategoryService;
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
