@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @forelse($tasks as $task)
                    <div class="card">
                        <div class="card-header">
                            Задача № {{$task->id}}&nbsp;&nbsp;
                            @if ($task->performed)
                                <span class="badge badge-success">Обработана</span>
                            @else
                                <span class="badge badge-primary">Не обработана</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <strong>Имя пользователя:</strong>
                                    {{ $task->name }}
                                </div>
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {{ $task->email }}
                                </div>
                                <div class="form-group">
                                    <strong>Текст задачи:</strong><br>
                                    {{ $task->task }}
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    Пока нет задач
                @endforelse

                @if ($paginate['isPaginated'])
                    <nav aria-label="Page pagination">
                        <ul class="pagination justify-content-center">
                            @if($paginate['back'])
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ url_for_paginate('/', $paginate['back'], $order) }}"
                                       aria-label="Назад">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item  disabled ">
                                    <a class="page-link" href="" aria-label="Назад">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            @endif
                            @for($i = 1; $i <= $paginate['countPages']; $i++)
                                <li class="page-item @if($i == $paginate['current']) active @endif">
                                    <a class="page-link"
                                       href="{{ url_for_paginate('/', $i, $order) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if($paginate['next'])
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ url_for_paginate('/', $paginate['next'], $order) }}"
                                       aria-label="Вперед">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item  disabled ">
                                    <a class="page-link" href="" aria-label="Вперед">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </nav>
                @endif

                <form action="{{ url('add-task') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="name">Имя пользователя</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Введите ваше имя">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control"
                               id="email" name="email"
                               placeholder="Введите ваш e-mail">
                    </div>
                    <div class="form-group">
                        <label for="task">Задача</label>
                        <textarea class="form-control" id="task" name="task" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </form>
            </div>
        </div>
    </div>
@endsection