<?php

namespace Validators;

use Src\Request;
use function HRValidator\validate;

class DivisionValidator
{
    public static function validateCreate(Request $request): array
    {
        $rules = [
            'division_name' => ['required'],
            'division_type_id' => ['required']
        ];

        $messages = [
            'required' => 'Поле :field пусто',
            'unique' => 'Поле :field должно быть уникально'
        ];

        $validator = validate($request->all(), $rules, $messages);
        return [
            'valid' => $validator->validate(),
            'errors' => $validator->errors()
        ];
    }
}