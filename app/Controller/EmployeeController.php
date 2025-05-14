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

        $categoryId = isset($request->all()['category_id']) ? (int)$request->all()['category_id'] : null;
    
        return new View('employee.by_category', [
            'categories' => StaffCategory::all(),
            'employees' => Employee::getByCategory($categoryId),
            'selected_category_id' => $categoryId
        ]);
    }

    public function changeDivision(Request $request): string
    {
        $employeeId = (int)$request->get('id');
        $newDivisionId = $request->get('division_id') !== '' 
            ? (int)$request->get('division_id') 
            : null;
    
        if ($request->method === 'POST') {
            try {
                Employee::changeDivision($employeeId, $newDivisionId);
                app()->route->redirect('/dashboard');
            } catch (\InvalidArgumentException $e) {
                return new View('employee.change_division', [
                    'employee' => Employee::with(['division'])->find($employeeId),
                    'divisions' => Division::all(),
                    'message' => $e->getMessage(),
                    'old' => $request->all()
                ]);
            }
        }
        
        return new View('employee.change_division', [
            'employee' => Employee::with(['division'])->find($employeeId),
            'divisions' => Division::all()
        ]);
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