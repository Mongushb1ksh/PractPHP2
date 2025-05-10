<?php
namespace Controller;

use Model\{Division, DivisionType, Employee};
use Src\View;
use Src\Request;
use function HRValidator\validate;

class DivisionController
{
    public function show(Request $request): string{
        $id = $request->get('id');
        $division = Division::with([
            'type',
            'employees' => function($query) {
                $query->with(['position', 'staffCategory']);
            }
        ])->find($id);
        if (!$division) {return new View('errors.404', [], 404);}
        return (new View())->render('divisions.show', [
            'division' => $division,
            'employees' => $division->employees
        ]);
    }

    public function createDivision(Request $request): string{
        $division_types = DivisionType::all();
        if ($request->method === 'POST') {
            $validator = validate($request->all(), [
                'division_name' =>  ['required'],
                'division_type_id' =>  ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if (!$validator->validate()) {
                // Собираем все ошибки в одну строку
                $errorMessages = [];
                foreach ($validator->errors() as $field => $errors) {
                    $errorMessages[] = implode(', ', $errors);
                }
                $message = implode('; ', $errorMessages);
    
                return new View('divisions.create', [
                    'division_types' => $division_types,
                    'message' => $message,
                    'old' => $request->all()
                ]);
            }
            if (Division::create(['division_name' => $request->division_name, 'division_type_id' => $request->division_type_id])) 
            {
                app()->route->redirect('/dashboard');
            }
        }
        return new View('divisions.create', ['division_types' => $division_types]);    
    }
}