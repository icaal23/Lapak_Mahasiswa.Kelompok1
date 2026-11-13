<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'name' => ['required', 'string', 'max:255'],
        'program_studi' => ['required', 'string', 'max:100'],
        'email' => [
            'required', 'string', 'lowercase', 'email', 'max:255',
            Rule::unique(User::class)->ignore($this->user()->id),
        ],
        'no_whatsapp' => ['nullable', 'regex:/^[0-9+\s-]{8,20}$/'],
        'lokasi_ambil' => ['nullable', 'string', 'max:255'],
    ];
}

public function messages(): array
{
    return [
        'no_whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, tanda + atau -, 8 sampai 20 karakter.',
    ];
}
    }

