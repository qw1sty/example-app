@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список завдань</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Створити нове завдання</a>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Назва</th>
                <th>Опис</th>
                <th>Статус</th>
                <th>Дата завершення</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>
                        <div class="d-flex justify-content-start align-items-center">
                            @if (auth()->check() && auth()->user()->role === 'admin')

                                <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn {{ $task->is_completed ? 'btn-secondary' : 'btn-success' }}">
                                        {{ $task->is_completed ? 'Не виконано' : 'Виконано' }}
                                    </button>
                                </form>

                                <!-- Кнопка редагування -->
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning me-2">Редагувати</a>

                                <!-- Форма для видалення -->
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline-block me-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

