<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\StoreProductRequest;
use App\Services\Seller\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->store($request->validated(), $request->user()->id);

        return response()->json($product, 201);
    }
}
