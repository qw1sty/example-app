@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Створити нове завдання</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Назва завдання</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Опис завдання</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option value="new">Нове</option>
                    <option value="in_progress">В процесі</option>
                    <option value="completed">Завершене</option>
                </select>
            </div>

            <div class="form-group">
                <label for="due_date">Дата завершення</label>
                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}">
            </div>

            <button type="submit" class="btn btn-primary">Створити завдання</button>
        </form>
    </div>
@endsection
