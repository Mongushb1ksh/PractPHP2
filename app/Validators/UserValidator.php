<?php

namespace Validators;

use Src\Request;
use function HRValidator\validate;

class UserValidator
{
    public static function validateCreate(Request $request): array
    {
        $rules = [
            'name' => ['required'],
            'lastName' => ['required'],
            'login' => ['required', 'unique:users,login'],
            'password' => ['required']
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