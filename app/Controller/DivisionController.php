<?php
namespace Controller;

use Model\{Division, DivisionType, Employee};
use Src\View;
use Src\Request;

class DivisionController
{
    public function show(Request $request): string
    {
        $division = Division::getWithDetails($request->get('id'));
        
        if (!$division) {
            return new View('errors.404', [], 404);
        }
        
        return (new View())->render('divisions.show', [
            'division' => $division,
            'employees' => $division->employees
        ]);
    }

    public function createDivision(Request $request): string
    {
        if ($request->method === 'POST') {
            try {
                if (Division::createDivision($request->all())) {
                    app()->route->redirect('/dashboard');
                }
            } catch (\InvalidArgumentException $e) {
                return new View('divisions.create', [
                    'division_types' => DivisionType::all(),
                    'message' => $e->getMessage(),
                    'old' => $request->all()
                ]);
            }
        }
        
        return new View('divisions.create', [
            'division_types' => DivisionType::all()
        ]);
    }
}