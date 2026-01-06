<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Получить список всех задач
     */
    public function index()
    {
        return response()->json(Task::all());
    }

    /**
     * Создать новую задачу
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Task::$rules);
        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    /**
     * Получить задачу по ID
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Обновить существующую задачу
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $validated = $request->validate(Task::$rules);
        $task->update($validated);
        return response()->json($task);
    }

    /**
     * Удалить задачу
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
