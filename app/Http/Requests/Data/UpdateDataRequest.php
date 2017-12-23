<?php

namespace App\Http\Requests\Data;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:191'],
            'data' => ['array', 'min:1'],
            'data.*.label' => ['max:191'],
            'data.*.value' => ['max:191'],
        ];
    }
}
