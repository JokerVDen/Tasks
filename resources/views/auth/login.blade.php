@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @php $errors=errors() @endphp
            @include('includes.flashes', compact('errors'))
            <div class="card">
                <div class="card-header">Вход</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        <div class="form-group row">
                            <label for="Login" class="col-sm-4 col-form-label text-md-right">Login</label>

                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control @if(isset($errors['login'])) is-invalid @endif" name="login" value="{{ old('login') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <button class="btn btn-primary" type="submit">Войти</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
