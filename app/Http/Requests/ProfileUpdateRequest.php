<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Siapkan data sebelum validasi.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower($this->email),
        ]);
    }

    /**
     * Rules validasi untuk update profil user.
     */
    public function rules(): array
    {
        return [
        'name' => ['sometimes', 'required', 'string', 'max:255'],
        'email' => [
            'sometimes',
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            Rule::unique(User::class, 'email')->ignore($this->user()->user_id, 'user_id'),
        ],
        'phone' => ['sometimes', 'required', 'string', 'max:20'],
        'address' => ['sometimes', 'required', 'string', 'max:255'],
    ];
    }

}
