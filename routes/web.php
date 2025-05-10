<?php
use Src\Route;
Route::add('GET', '/divisions/show', [Controller\DivisionController::class, 'show']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/profile', [Controller\ProfileController::class, 'profile']);
Route::add('GET', '/dashboard', [Controller\AdminController::class, 'dashboard']);
Route::add(['GET', 'POST'], '/employees/create', [Controller\EmployeeController::class, 'create'])->middleware('auth');
Route::add(['GET', 'POST'], '/divisions/create', [Controller\DivisionController::class, 'createDivision']);
Route::add(['GET'], '/employee/by_category', [Controller\EmployeeController::class, 'employeesByCategory']);
Route::add(['GET', 'POST'], '/employee/change_division', [Controller\EmployeeController::class, 'changeDivision']);
//admin
Route::add(['GET', 'POST'], '/admin/create_hr', [Controller\AdminController::class, 'createHr']);
Route::add('GET', '/admin/dashboard', [Controller\AdminController::class, 'dashboard']);

