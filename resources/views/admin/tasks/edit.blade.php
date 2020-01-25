@extends('layouts.app')
@section('page-title', $pageTitle)
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @php $errors=errors() @endphp
                @include('includes.flashes', compact('errors'))
                <div class="card">
                    <div class="card-body">
                        <h2>Редактировать задачу</h2>
                        <br>
                        <form action="{{ url('/task/update/'.$task->id) }}" method="post" class="form-new-task">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label for="name">Имя пользователя</label>
                                <input type="text" class="form-control @if(isset($errors['name'])) is-invalid @endif"
                                       id="name" name="name"
                                       placeholder="Введите ваше имя" value="{{ old('name', $task->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @if(isset($errors['email'])) is-invalid @endif"
                                       id="email" name="email" value="{{ old('email', $task->email) }}"
                                       placeholder="Введите ваш e-mail">
                            </div>
                            <div class="form-group">
                                <label for="task">Задача</label>
                                <textarea class="form-control @if(isset($errors['task'])) is-invalid @endif" id="task"
                                          name="task" rows="3">{{ old('task', $task->task) }}</textarea>
                            </div>
                            <input type="hidden" name="status" value="0">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status"
                                @if($task->status) checked @endif value="1">
                                <label class="form-check-label" for="status">Выполнена</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection