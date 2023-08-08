<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class TrustedContactUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'contact_name' => 'sometimes|required|string|max:100',
            'contact_number' => 'sometimes|nullable|string|max:20',
            'contact_email' => 'sometimes|nullable|email|max:100',
        ];
    }



    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
