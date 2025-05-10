<?php
namespace Controller;

use Model\User;
use Model\Division;
use Model\Employee;
use Src\View;
use Src\Auth\Auth;
use Src\Request;
use function HRValidator\validate;

class AdminController
{
    public function dashboard(Request $request): string{
        $user = Auth::user();
        if ($user->role === 'hr') {
            $employees = Employee::all();
            $divisions = Division::all();
            return new View('hr.dashboard', [
                'employees' => $employees,
                'divisions' => $divisions
            ]);
        }
        if ($user->role === 'admin') {
            $users = User::all();
            return new View('admin.dashboard', ['users' => $users]);
        }
        return new View('site.login');
    }

    public function profile(Request $request): string{
        $user = Auth::user();
        return new View('site.profile', ['user' => $user,]);
    }
 
    public function createHr(Request $request): string{
        if ($request->method === 'POST') {
            $validator = validate($request->all(), [
                'name' => ['required'],
                'lastName' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if (!$validator->validate()) {
                $errorMessages = [];
                foreach ($validator->errors() as $field => $errors) {
                    $errorMessages[] = implode(', ', $errors);
                }
                $message = implode('; ', $errorMessages);
    
                return new View('admin.create_hr', [
                    'message' => $message,
                    'old' => $request->all()
                ]);
            }
            if (User::create($request->all())) {app()->route->redirect('/dashboard');}
        }
        return new View('admin.create_hr');
    }
}