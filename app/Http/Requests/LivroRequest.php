<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NestedSubindicesRule;

class LivroRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'indices' => 'required|array',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('indices.*', ['array', new NestedSubindicesRule()], function ($input) {
            return is_array($input['indices']);
        });
    }

}
