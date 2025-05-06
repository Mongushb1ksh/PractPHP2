<?php

namespace Controller;


use Model\Post;
use Model\User;
use Model\Division;
use Model\DivisionType;
use Model\Position;
use Model\StaffCategory;
use Model\Employee;
use Src\View;
use Src\Request;
use Src\Auth\Auth;

class Site
{


    
    public function login(Request $request): string
    {
       //Если просто обращение к странице, то отобразить форму
       if ($request->method === 'GET') {
           return new View('site.login');
       }
       //Если удалось аутентифицировать пользователя, то редирект
       if (Auth::attempt($request->all())) {
           app()->route->redirect('/profile');
       }
       //Если аутентификация не удалась, то сообщение об ошибке
       return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }
    
    public function index(): string
    {
        $posts = Post::all();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }

 
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
 
    public function signup(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/');
        }
        return new View('site.signup');
    }
    public function dashboard(Request $request): string
    {
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

    public function profile(Request $request): string
    {
        $user = Auth::user();
        
        return new View('site.profile', [
            'user' => $user,
        ]);
    }


    public function create(Request $request): string
    {
        // Получаем справочники для формы
        $divisions = Division::all();
        $positions = Position::all();
        $categories = StaffCategory::all();

        if ($request->method === 'POST') {
            // Валидация данных
            $validation = ([
                'last_name' => ['required'],
                'first_name' => ['required'],
                'birth_date' => ['required', 'date'],
                'division_id' => ['required', 'numeric'],
                'position_id' => ['required', 'numeric'],
                'staff_category_id' => ['required', 'numeric']
            ]);

            if ($validation && Employee::create($request->all())) {
                Division::where('division_id', $request->division_id)->increment('employee_count');
                app()->route->redirect('/dashboard');
            }
        }

        return new View('employee.create', [
            'divisions' => $divisions,
            'positions' => $positions,
            'categories' => $categories,
            'errors' => $validation['errors'] ?? []
        ]);
    }
    public function show(Request $request): string
    {
        // Разбираем URI чтобы извлечь ID
        $id = $request->get('id');
        
        $division = Division::with([
            'type',
            'employees' => function($query) {
                $query->with(['position', 'staffCategory']);
            }
        ])->find($id);

        
        if (!$division) {
            return new View('errors.404', [], 404);
        }
        return (new View())->render('divisions.show', [
            'division' => $division,
            'employees' => $division->employees
        ]);
    }

    public function createHr(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/dashboard');
        }

        return new View('admin.create_hr');
    }

    public function createDivision(Request $request): string
    {
        $division_types = DivisionType::all();

        if ($request->method === 'POST') {
            Division::create([
                'division_name' => $request->division_name,
                'division_type_id' => $request->division_type_id
            ]);
            app()->route->redirect('/dashboard');
        }

        return new View('divisions.create', [
            'division_types' => $division_types
        ]);    
    }


    public function employeesByCategory(Request $request): string
    {
        // Получаем все категории персонала
        $categories = StaffCategory::all();
    
        // Если передан ID категории, фильтруем сотрудников
        $categoryId = isset($request->all()['category_id']) ? $request->get('category_id') : null;
        if ($categoryId) {
            $employees = Employee::where('staff_category_id', $categoryId)
                ->with(['position', 'division'])
                ->get();
        } else {
            $employees = [];
        }
    
        return new View('employee.by_category', [
            'categories' => $categories,
            'employees' => $employees ?? [],
            'selected_category_id' => $categoryId
        ]);
    }

    public function changeDivision(Request $request): string
    {

        $id = $request->get('id');

        $id = $request->get('id');
        
        $employee = Employee::with(['division',])->find($id);


        $divisions = Division::all();

        if ($request->method === 'POST') {

            $oldDivisionId = $employee->division_id;
            $newDivisionId = $request->division_id;

            $employee->update(['division_id' => $newDivisionId]);

            app()->route->redirect('/dashboard');
        }

        return new View('employee.change_division', [
            'employee' => $employee,
            'divisions' => $divisions
        ]);
    }
}

