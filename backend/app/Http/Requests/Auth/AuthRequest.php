<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

abstract class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Emails are stored and matched lowercased, so normalise before validation.
     */
    protected function prepareForValidation(): void
    {
        $email = $this->input('email');

        if (is_string($email)) {
            $this->merge(['email' => Str::lower($email)]);
        }
    }
}
