<?php

use Src\Route;


Route::add('GET', '/divisions/show', [Controller\Site::class, 'show']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/profile', [Controller\Site::class, 'profile']);

Route::add('GET', '/admin/dashboard', [Controller\Site::class, 'dashboard']);
Route::add('GET', '/dashboard', [Controller\Site::class, 'dashboard']);

Route::add(['GET', 'POST'], '/employees/create', [Controller\Site::class, 'create'])->middleware('auth');
Route::add(['GET', 'POST'], '/divisions/create', [Controller\Site::class, 'createDivision']);
Route::add(['GET'], '/employee/by_category', [Controller\Site::class, 'employeesByCategory']);
Route::add(['GET', 'POST'], '/employee/change_division', [Controller\Site::class, 'changeDivision']);

//admin
Route::add(['GET', 'POST'], '/admin/create_hr', [Controller\Site::class, 'createHr']);

