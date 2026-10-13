<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class OwnerService
{
    public function store(array $data): User
    {
        $owner = User::query()->create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? null,
            'shop_name' => $data['shop_name'] ?? null,
            'password'  => Hash::make($data['password']),
        ]);

        $owner->forceFill([
            'role'               => 'owner',
            'is_active'          => $data['is_active'] ?? false,
            'email_verified_at'  => now(),
        ])->save();

        return $owner;
    }

    public function getOwners(): Collection
    {
        return User::query()
            ->where('role', 'owner')
            ->get(['id', 'name', 'email', 'phone', 'shop_name', 'is_active']);
    }
}
