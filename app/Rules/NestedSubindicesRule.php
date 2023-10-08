<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class NestedSubindicesRule implements Rule
{
    public function passes($attribute, $value)
    {
        $subindiceRules = [
            'titulo' => 'required|string|max:255',
            'pagina' => 'required|integer',
            'subindices' => 'array',
        ];

        $validator = Validator::make([$attribute => $value], [$attribute => $subindiceRules]);

        if ($validator->fails()) {
            return false;
        }

        if (isset($value['subindices']) && is_array($value['subindices'])) {
            foreach ($value['subindices'] as $subindice) {
                $nestedRule = new NestedSubindicesRule();
                if (!$nestedRule->passes($attribute, $subindice)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function message()
    {
        return 'Os subindices são inválidos.';
    }
}