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
use Src\Validator\Validator;
class Site
{
    public function login(Request $request): string{
       if ($request->method === 'GET') {return new View('site.login');}
       if (Auth::attempt($request->all())) {app()->route->redirect('/profile');}
       return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }
    
    public function index(): string{
        $posts = Post::all();
        return (new View())->render('site.post', ['posts' => $posts]);
    }
    public function logout(): void{
        Auth::logout();
        app()->route->redirect('/');
    }
    public function hello(): string{
        return new View('site.hello', ['message' => 'hello working']);
    }
 
    public function signup(Request $request): string{
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'lastName' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if($validator->fails()){
                return new View('site.signup', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            if (User::create($request->all())) {app()->route->redirect('/');}
        }
        return new View('site.signup');
    }
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
    public function create(Request $request): string
    {
        $divisions = Division::all();
        $positions = Position::all();
        $categories = StaffCategory::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'birth_date' => ['required'],
                'registration_address' => ['required'],
                'division_id' => ['required'],
                'position_id' => ['required'],
                'staff_category_id' => ['required']
            ], [
                'required' => 'Поле :field обязательно для заполнения.',
                'date' => 'Поле :field должно быть датой.',
                'numeric' => 'Поле :field должно быть числом.'
            ]);
            if ($validator->fails()) {               
                return new View('employee.create', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }
            $data = $request->all();
            $errors = [];
            if (!empty($errors)) {
                return new View('employee.create', [
                    'divisions' => $divisions,
                    'positions' => $positions,
                    'categories' => $categories,
                    'errors' => $errors
                ]);
            }
            Employee::create([
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'birth_date' => $data['birth_date'],
                'registration_address' => $data['registration_address'],
                'division_id' => $data['division_id'],
                'position_id' => $data['position_id'],
                'staff_category_id' => $data['staff_category_id']
            ]);
            Division::where('division_id', $data['division_id'])->increment('employee_count');
            app()->route->redirect('/dashboard');
        }

        return new View('employee.create', [
            'divisions' => $divisions,
            'positions' => $positions,
            'categories' => $categories,
            'errors' => []
        ]);
    }
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
    public function createHr(Request $request): string{
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'lastName' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if($validator->fails()){
                return new View('admin.create_hr', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            if (User::create($request->all())) {app()->route->redirect('/dashboard');}
        }
        return new View('admin.create_hr');
    }
    public function createDivision(Request $request): string{
        $division_types = DivisionType::all();
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'division_name' =>  ['required'],
                'division_type_id' =>  ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if($validator->fails()){
                return new View('divisions.create', ['division_types' => $division_types, 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            if (Division::create(['division_name' => $request->division_name, 'division_type_id' => $request->division_type_id])) 
            {
                app()->route->redirect('/dashboard');
            }
        }
        return new View('divisions.create', ['division_types' => $division_types]);    
    }


    public function employeesByCategory(Request $request): string{
        $categories = StaffCategory::all();
        $categoryId = isset($request->all()['category_id']) ? $request->get('category_id') : null;
        if ($categoryId) {
            $employees = Employee::where('staff_category_id', $categoryId)
                ->with(['position', 'division'])
                ->get();} else {$employees = [];}
        return new View('employee.by_category', [
            'categories' => $categories,
            'employees' => $employees ?? [],
            'selected_category_id' => $categoryId
        ]);
    }
    public function changeDivision(Request $request): string {
        $id = $request->get('id');
        $employee = Employee::with(['division',])->find($id);
        $divisions = Division::all();
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'division_id' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
            ]);
            if($validator->fails()){
                return new View('employee.change_division', ['employee' => $employee,'divisions' => $divisions, 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            $newDivisionId = $request->division_id;
            if ($employee->update(['division_id' => $newDivisionId])) {
                app()->route->redirect('/dashboard');
            }        
        }
        return new View('employee.change_division', ['employee' => $employee,'divisions' => $divisions]);


    }
}

