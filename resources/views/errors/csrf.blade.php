@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ошибка</div>
                    <div class="card-body">
                        CSRF токен недействителен или отсутствует
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection