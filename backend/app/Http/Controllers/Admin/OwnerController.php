<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOwnerRequest;
use App\Services\Admin\OwnerService;
use Illuminate\Http\JsonResponse;

class OwnerController extends Controller
{
    public function __construct(private OwnerService $service) {}

    public function index()
    {
        $owners = $this->service->getOwners();
        return view('admin.owners.index', compact('owners'));
    }

    public function store(StoreOwnerRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.owners')
            ->with('success', 'Owner created successfully.');
    }

}
