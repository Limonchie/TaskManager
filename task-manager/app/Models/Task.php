<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Сущность/модель данных для работы с задачами
 */
class Task extends Model
{
    use HasFactory;

    /**
     * Поля, доступные для массового заполнения
     */
    protected $fillable = ['title', 'description', 'status'];

    /**
     * Правила валидации для модели
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'in:pending,in_progress,completed'
    ];
}
