# Task Manager API

Простое REST API для управления задачами, разработанное на Laravel.

## Требования

- Docker и Docker Compose

## Установка с помощью Docker

1. Клонируйте репозиторий:
   ```bash
   git clone [ваш-репозиторий] task-manager
   cd task-manager
   ```

2. Настройте файл окружения:
   ```bash
   cp .env.example .env
   ```

3. Запустите приложение (все настройки уже предустановлены):
   ```bash
   docker-compose up -d --build
   ```

   При первом запуске автоматически:
   - Создастся база данных MySQL
   - Применятся все миграции
   - Запустится веб-сервер

## Доступ к приложению

- API: http://localhost:8000/api/tasks

## Работа с API

### Получить список задач
```
GET /api/tasks
```

### Создать задачу
```
POST /api/tasks
```
Тело запроса:
```json
{
    "title": "Название задачи",
    "description": "Описание задачи",
    "status": "pending"
}
```

### Получить задачу по ID
```
GET /api/tasks/{id}
```

### Обновить задачу
```
PUT /api/tasks/{id}
```
Тело запроса (можно обновлять отдельные поля):
```json
{
    "status": "in_progress"
}
```

### Удалить задачу
```
DELETE /api/tasks/{id}
```

## Параметры задач

- `title`: строка, обязательно, макс. 255 символов
- `description`: текст, необязательно
- `status`: enum, по умолчанию "pending", возможные значения:
  - `pending` - ожидает выполнения
  - `in_progress` - в процессе
  - `completed` - завершена

## Тестирование

### Запуск тестов

```bash
# Запуск всех тестов
docker-compose exec app php artisan test

# С подробным выводом
docker-compose exec app php artisan test --verbose

# Запуск конкретного теста
docker-compose exec app php artisan test --filter=test_create_task
