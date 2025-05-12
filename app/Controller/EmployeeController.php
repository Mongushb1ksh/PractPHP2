<?php
namespace Controller;

use Model\{Employee, Division, Position, StaffCategory};
use Src\View;
use Src\Request;
use Validators\EmployeeValidator;


class EmployeeController
{
    public function create(Request $request): string
    {
        $divisions = Division::all();
        $positions = Position::all();
        $categories = StaffCategory::all();

        if ($request->method === 'POST') {
            $result = EmployeeValidator::validateCreate($request);

            if (!$result['valid']) {
                $errorMessages = [];
                foreach ($result['errors'] as $field => $errors) {
                    $errorMessages[] = implode(', ', $errors);
                }
                $message = implode('; ', $errorMessages);
    
                return new View('employee.create', [
                    'divisions' => $divisions,
                    'positions' => $positions,
                    'categories' => $categories,
                    'message' => $message,
                    'old' => $request->all()
                ]);
            }
            $data = $request->all();
            $employee = Employee::create([
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'birth_date' => $data['birth_date'],
                'registration_address' => $data['registration_address'],
                'division_id' => $data['division_id'],
                'position_id' => $data['position_id'],
                'staff_category_id' => $data['staff_category_id']
            ]);

            $employee->division->updateEmployeeCount();
            $employee->division->updateAverageAge();
            app()->route->redirect('/dashboard');
        }

        return new View('employee.create', [
            'divisions' => $divisions,
            'positions' => $positions,
            'categories' => $categories,
            'errors' => []
        ]);
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
            $result = EmployeeValidator::validateChangeDivision($request);

            if (!$result['valid']) {
                $errorMessages = [];
                foreach ($result['errors'] as $field => $errors) {
                    $errorMessages[] = implode(', ', $errors);
                }
                $message = implode('; ', $errorMessages);
    
                return new View('employee.change_division', [
                    'employee' => $employee,
                    'divisions' => $divisions,
                    'message' => $message,
                    'old' => $request->all()
                ]);

            }
            $oldDivisionId = $employee->division_id;
            $newDivisionId = $request->division_id;

            if ($employee->update(['division_id' => $newDivisionId])) {
                $division = Division::find($oldDivisionId);
                if($division !== null){
                    $division->updateEmployeeCount();
                    $division->updateAverageAge();

                }
                $division = Division::find($newDivisionId);
                if($division !== null){
                    $division->updateEmployeeCount();
                    $division->updateAverageAge();
                }
                app()->route->redirect('/dashboard');
            }
        }
        return new View('employee.change_division', ['employee' => $employee,'divisions' => $divisions]);
    }

    protected function returnWithErrors(string $view, array $errors, array $data = []): View
    {
        $errorMessages = [];
        foreach ($errors as $field => $fieldErrors) {
            $errorMessages[] = implode(', ', $fieldErrors);
        }
        
        $data['message'] = implode('; ', $errorMessages);
        return new View($view, $data);
    }
}