<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSellerRequest;
use App\Services\Admin\SellerService;

class SellerController extends Controller
{
    public function __construct(private SellerService $service) {}

    public function index()
    {
        $sellers = $this->service->getSellers();
        return view('admin.sellers.index', compact('sellers'));
    }

    public function store(StoreSellerRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.sellers')
            ->with('success', 'Seller created successfully.');
    }

    public function show($id)
    {
        $seller = $this->service->getSellerById($id);
        return view('admin.sellers.show', compact('seller'));
    }
}
