<?php
namespace Controller;

use Model\{Employee, Division, Position, StaffCategory};
use Src\View;
use Src\Request;

class EmployeeController
{
    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            try {
                Employee::createEmployee($request->all());
                app()->route->redirect('/dashboard');
            } catch (\InvalidArgumentException $e) {
                return $this->returnWithErrors('employee.create', 
                    ['errors' => $e->getMessage()],
                    $this->getFormData()
                );
            }
        }
        
        return new View('employee.create', $this->getFormData());
    }

    public function employeesByCategory(Request $request): string
    {
        return new View('employee.by_category', [
            'categories' => StaffCategory::all(),
            'employees' => Employee::getByCategory($request->get('category_id')),
            'selected_category_id' => $request->get('category_id')
        ]);
    }

    public function changeDivision(Request $request): string
    {
        if ($request->method === 'POST') {
            try {
                Employee::changeDivision(
                    $request->get('id'),
                    $request->division_id
                );
                app()->route->redirect('/dashboard');
            } catch (\InvalidArgumentException $e) {
                return $this->returnWithErrors('employee.change_division', 
                    ['errors' => $e->getMessage()],
                    $this->getChangeDivisionData($request->get('id'))
                );
            }
        }
        
        return new View('employee.change_division', 
            $this->getChangeDivisionData($request->get('id'))
        );
    }

    private function getFormData(): array
    {
        return [
            'divisions' => Division::all(),
            'positions' => Position::all(),
            'categories' => StaffCategory::all(),
            'errors' => []
        ];
    }
    
    private function getChangeDivisionData(int $employeeId): array
    {
        return [
            'employee' => Employee::with(['division'])->find($employeeId),
            'divisions' => Division::all()
        ];
    }
    
    private function returnWithErrors(string $view, array $errors, array $data = []): View
    {
        $data['message'] = is_array($errors['errors']) ? 
            implode('; ', $errors['errors']) : $errors['errors'];
            
        return new View($view, $data);
    }
}