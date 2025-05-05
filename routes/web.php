<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/admin/dashboard', [Controller\Site::class, 'dashboard']);
Route::add('GET', '/dashboard', [Controller\Site::class, 'dashboard']);

Route::add(['GET', 'POST'], '/employees/create', [Controller\Site::class, 'create'])->middleware('auth');
Route::add('GET', '/divisions/{id}', [Controller\Site::class, 'show']);