<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Маршруты
|--------------------------------------------------------------------------
|
| Доступные маршруты:
| GET /api/tasks - Получить список всех задач
| POST /api/tasks - Создать новую задачу
| GET /api/tasks/{id} - Получить задачу по ID
| PUT/PATCH /api/tasks/{id} - Обновить задачу
| DELETE /api/tasks/{id} - Удалить задачу
*/
// Регистрация RESTful-ресурса для работы с задачами

Route::apiResource('tasks', TaskController::class);
