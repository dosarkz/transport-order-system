@extends('layouts.app')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Редактировать контрагента</h3>
        </div>

        @include("{$viewPath}.form",['model' => $model, 'url' => $url])
    </div>
@endsection



