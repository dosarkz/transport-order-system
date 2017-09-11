@extends('layouts.app')
@section('title')
    Добавить заявку
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Создать пользователя</h3>
        </div>

        @include("{$viewPath}.form",['model' => $model, 'url' => $url])
    </div>
@endsection