<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/todo', function () {
    return Inertia::render('ToDo/Index');
});
Route::get('/todo/create', function () {
    // @todo: zwracać też użytkownika
    return Inertia::render('ToDo/Form', [
        // 'user' => auth()->user(),
        'user' => \App\Models\User::first(),
    ]);
});
Route::get('/todo/edit/{id}', function (int $id) {
    // @todo: zwracać też użytkownika
    return Inertia::render('ToDo/Form', [
        'id' => $id,
        'user' => \App\Models\User::first(),
    ]);
});
// Route::get('/todo', [\App\Http\Controllers\ToDoController::class, 'index']);
// Route::get('/todo/list', [\App\Http\Controllers\ToDoController::class, 'list']);
// Route::post('/todo/create', [\App\Http\Controllers\ToDoController::class, 'create']);
// Route::delete('/todo/delete', [\App\Http\Controllers\ToDoController::class, 'delete']);
