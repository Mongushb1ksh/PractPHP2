<?php
namespace Controller;

use Model\User;
use Model\Employee;
use Src\View;
use Src\Request;

class AdminController
{
    public function dashboard(): string
    {
        $user = User::getAuthenticatedUser();
        
        if ($user->role === 'hr') {
            $data = Employee::getAllWithDivisions();
            return new View('hr.dashboard', $data);
        }
        
        if ($user->role === 'admin') {
            return new View('admin.dashboard', [
                'users' => User::getAllByRole('hr')
            ]);
        }
        
        return new View('site.login');
    }

    public function profile(): string
    {
        return new View('site.profile', [
            'user' => User::getAuthenticatedUser()
        ]);
    }
 
    public function createHr(Request $request): string
    {
        if ($request->method === 'POST') {
            if (User::createHr($request->all())) {
                app()->route->redirect('/dashboard');
            }
            
            return new View('admin.create_hr', [
                'message' => 'Ошибка при создании HR',
                'old' => $request->all()
            ]);
        }
        
        return new View('admin.create_hr');
    }
}