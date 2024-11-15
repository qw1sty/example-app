<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Показати всі завдання
    public function index()
    {
        $tasks = Task::all(); // Отримуємо всі завдання
        return view('tasks.index', compact('tasks')); // Повертаємо представлення з передачею даних
    }

    // Показати форму для створення нового завдання
    public function create()
    {
        return view('tasks.create'); // Повертаємо представлення для створення нового завдання
    }

    // Зберегти нове завдання
    public function store(Request $request)
    {
        // Валідація даних
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:new,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        // Створення завдання
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => auth()->id(), // Встановлюємо поточного користувача як автора завдання
        ]);

        return redirect()->route('tasks.index')->with('success', 'Завдання створено успішно.');
    }

    // Показати конкретне завдання
    public function show(Task $task)
    {
        return view('tasks.show', compact('task')); // Повертаємо представлення з конкретним завданням
    }

    // Показати форму для редагування завдання
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task')); // Повертаємо форму для редагування завдання
    }

    // Оновити завдання
    public function update(Request $request, Task $task)
    {
        // Валідація
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:new,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        // Оновлення завдання
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Завдання оновлено успішно.');
    }

    // Видалити завдання
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Завдання видалено.');
    }
    public function toggleComplete($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->is_completed = !$task->is_completed;
            $task->save();
        }

        return redirect()->back();
    }
}
