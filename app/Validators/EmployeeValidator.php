<?php

namespace Validators;

use Src\Request;
use function HRValidator\validate;

class EmployeeValidator
{
    public static function validateCreate(Request $request): array
    {
        $rules = [
            'last_name' => ['required'],
            'first_name' => ['required'],
            'birth_date' => ['required', 'date'],
            'registration_address' => ['required'],
            'division_id' => ['required'],
            'position_id' => ['required'],
            'staff_category_id' => ['required']
        ];

        $messages = [
            'required' => 'Поле :field обязательно для заполнения.',
            'date' => 'Поле :field должно быть датой.'
        ];

        $validator = validate($request->all(), $rules, $messages);
        return [
            'valid' => $validator->validate(),
            'errors' => $validator->errors()
        ];
    }

    public static function validateChangeDivision(Request $request): array
    {
        $rules = [
            'division_id' => ['required']
        ];

        $messages = [
            'required' => 'Поле :field пусто'
        ];

        $validator = validate($request->all(), $rules, $messages);
        return [
            'valid' => $validator->validate(),
            'errors' => $validator->errors()
        ];
    }
}