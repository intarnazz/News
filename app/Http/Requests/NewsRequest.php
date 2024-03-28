<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'content' => 'required',
            // 'files' => 'required|array|size:4',
            // 'files.*' => 'required|file|mimes:jpeg,jpg,png|max:2048'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $err = $validator->errors()->toArray();
        $res = new JsonResponse([
            'success' => false,
            'message' => $err,
        ], 422);
        throw new HttpResponseException($res);
    }
}
