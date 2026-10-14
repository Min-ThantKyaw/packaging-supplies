<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class SellerService
{
    public function store(array $data): User
    {
        $seller = User::query()->create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? null,
            'shop_name' => $data['shop_name'] ?? null,
            'password'  => Hash::make($data['password']),
        ]);

        $seller->forceFill([
            'role'              => 'seller',
            'is_active'         => $data['is_active'] ?? false,
            'email_verified_at' => now(),
        ])->save();

        return $seller;
    }

    public function getSellers(): Collection
    {
        return User::query()
            ->where('role', 'seller')
            ->get(['id', 'name', 'email', 'phone', 'shop_name', 'is_active', 'created_at']);
    }

    public function getSellerById(int $id): ?User
    {
        return User::query()
            ->where('role', 'seller')
            ->find($id, ['id', 'name', 'email', 'phone', 'shop_name', 'is_active']);
    }
}
