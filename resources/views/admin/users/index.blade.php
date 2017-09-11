@extends('layouts.app')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Пользователи</h3>
        </div>


        <div class="panel-group well">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1">Поиск</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">

                        {{ Form::open(array('method'=> 'GET'))}}

                        <div class="form-group">
                            <label for="id">id</label>
                            {{Form::number('id')}}
                        </div>

                        <div class="form-group">
                            <label for="first_name">Имя</label>
                            {{Form::text('first_name')}}
                        </div>

                        <div class="form-group">
                            <label for="last_name">Фамилия</label>
                            {{Form::text('last_name')}}
                        </div>

                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            {{Form::text('phone')}}
                        </div>

                        {{ Form::submit('Поиск') }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>

        @include('modals.modal')
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead class="thead-inverse">
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Телефон</th>
                            <th>Дата создания</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($models as $model)
                            <tr>
                                <td>{{ $model->id }}</td>
                                <td>{{ $model->first_name }}</td>
                                <td>{{ $model->last_name }}</td>
                                <td>{{ $model->phone }}</td>
                                <td>{{$model->created_at}}</td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="/{{$url}}/{{ $model->id }}/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    {{ Form::open(array('url' => '/'.$url.'/' . $model->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    <button class="btn btn-xs btn-danger delete" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $models->links() }}
                </div>
            </div>
    </div>
@endsection