<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIndicatorRequest extends FormRequest
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
            'name'                  => 'required|string',
            'theme_code'            => 'required|exists:themes,code',
            'measurement_unit'      => 'nullable|string|max:50',
            'measurement_frequency' => 'nullable|string|max:50',
            'responsible_user_id'   => 'required|exists:users,id',
            'short_term_goal'       => 'required|numeric|min:0',
        ];
    }
}
