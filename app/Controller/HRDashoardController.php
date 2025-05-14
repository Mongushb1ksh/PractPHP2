<?php
namespace Controller;

use Model\{Employee, Division};
use Src\View;

class HRDashboardController
{
    public function dashboard(): string
    {
        $employees = Employee::all();
        $divisions = Division::all();
        return new View('hr.dashboard', [
            'employees' => $employees,
            'divisions' => $divisions
        ]);
    }
}