<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  получение списка задач
     */
    public function test_get_all_tasks()
    {
        // Создаем тестовые задачи
        $tasks = Task::factory()->count(3)->create();

        // Отправляем GET запрос
        $response = $this->getJson('/api/tasks');

        // Проверяем успешный ответ и структуру данных
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'description', 'status', 'created_at', 'updated_at']
            ]);
    }

    /**
     *  созданияе задачи
     */
    public function test_create_task()
    {
        $taskData = [
            'title' => 'Новая задача',
            'description' => 'Описание новой задачи',
            'status' => 'pending'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'title', 'description', 'status', 'created_at', 'updated_at'
            ])
            ->assertJson([
                'title' => 'Новая задача',
                'description' => 'Описание новой задачи',
                'status' => 'pending'
            ]);

        // Проверяем, что задача сохранилась в БД
        $this->assertDatabaseHas('tasks', [
            'title' => 'Новая задача',
            'status' => 'pending'
        ]);
    }

    /**
     *  валидаци при создании задачи
     */
    public function test_validation_when_creating_task()
    {
        // Пробуем создать задачу без обязательного поля title
        $response = $this->postJson('/api/tasks', [
            'description' => 'Без заголовка',
            'status' => 'invalid_status'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'status']);
    }

    /**
     *  получение одной задачи
     */
    public function test_get_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status
            ]);
    }

    /**
     *  получение несуществующей задачи
     */
    public function test_get_nonexistent_task()
    {
        $response = $this->getJson('/api/tasks/999');
        $response->assertStatus(404);
    }

    /**
     * обновления задачи
     */
    public function test_update_task()
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $updateData = [
            'title' => 'Обновленный заголовок',
            'status' => 'in_progress'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Обновленный заголовок',
                'status' => 'in_progress'
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Обновленный заголовок',
            'status' => 'in_progress'
        ]);
    }

    /**
     * удаление задачи
     */
    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     *  фильтрация задач по статусу
     */
    public function test_filter_tasks_by_status()
    {
        Task::factory()->create(['status' => 'pending']);
        Task::factory()->create(['status' => 'completed']);
        Task::factory()->create(['status' => 'completed']);

        $response = $this->getJson('/api/tasks?status=completed');

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['status' => 'completed']);
    }
}
