<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\AdminAuthService;
use App\Http\Requests\Admin\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;

class AdminAuthController extends Controller
{
    public function __construct(private AdminAuthService $service) {}

    public function authenticate(AdminLoginRequest $request): RedirectResponse
    {
        if (! $this->service->attempt($request->validated(), $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->service->logout($request);

        return redirect()->route('login');
    }
}
