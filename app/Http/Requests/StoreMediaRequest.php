<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPatch = $this->isMethod('PATCH') || $this->isMethod('PUT');
        $presence = $isPatch ? 'sometimes' : 'required';

        // Saat update, judul milik media itu sendiri dikecualikan dari cek duplikat
        $uniqueTitle = Rule::unique('media', 'title');
        if ($isPatch && $this->route('media')) {
            $uniqueTitle->ignore($this->route('media')->id);
        }

        return [
            'title'        => [$presence, 'string', 'max:255', $uniqueTitle],
            'type'         => [$presence, 'string', 'max:50'],
            'genre'        => [$presence, 'string', 'max:100'],
            'release_year' => ['sometimes', 'nullable', 'integer', 'min:1888', 'max:' . (date('Y') + 5)],
            'description'  => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi',
            'title.unique'   => 'Judul media sudah terdaftar',
            'type.required'  => 'Jenis media wajib diisi',
            'genre.required' => 'Genre media wajib diisi',
        ];
    }
}
