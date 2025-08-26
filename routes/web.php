<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/todo', function () {
    return Inertia::render('ToDo/List', [
        'user' => 'asd',
    ]);
    // return view('todo.index');
});
// Route::get('/todo', [\App\Http\Controllers\ToDoController::class, 'index']);
Route::get('/todo/list', [\App\Http\Controllers\ToDoController::class, 'list']);
Route::post('/todo/create', [\App\Http\Controllers\ToDoController::class, 'create']);
