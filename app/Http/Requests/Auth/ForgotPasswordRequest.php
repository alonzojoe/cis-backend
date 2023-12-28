<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:users'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failed',
            'message' => $validator->errors(),
        ];

        $emailErrorMessage = $validator->errors()->first('email');

        if ($emailErrorMessage) {
            $response['message'] = $emailErrorMessage;
        }

        throw new HttpResponseException(response()->json($response, 422));
    }
}
