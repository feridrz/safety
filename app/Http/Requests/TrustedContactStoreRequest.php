<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class TrustedContactStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            '*.contact_name' => 'nullable|string|max:100',
            '*.contact_number' => 'required|string|max:20',
            '*.contact_email' => 'nullable|email|max:100',
        ];
    }



    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
