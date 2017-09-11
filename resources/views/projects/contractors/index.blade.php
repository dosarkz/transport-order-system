@extends('layouts.app')

@section('content')



    <div class="row">


        <section class="content-header">
            <h1>
                {{$project->name}}
                <small>управление проектом</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="pull pull-right">
                    <a href="/projects/{{$project->id}}/create-order" class="btn btn-xs btn-primary" id="project-create-order">создать заказ</a>
                </div>

            </div>
            <div class="row">
                <div class="nav-tabs-custom">
                    @include('projects.nav')
                    <div class="tab-content">


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
                                            <label for="id">Название</label>
                                            {{Form::text('company_name_full')}}
                                        </div>

                                        <div class="form-group">
                                            <label for="first_name">БИН/ИИН</label>
                                            {{Form::number('bin')}}
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Телефон</label>
                                            {{Form::number('phone')}}
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Адрес, факт.</label>
                                            {{Form::text('fact_address')}}
                                        </div>

                                        {{ Form::submit('Поиск') }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="orders" class="tab-pane active">
                            <div class="col s12">
                                <a href="/projects/{{$project->id}}/contractors/create" class="btn btn-primary"><i class="fa fa-plus"></i> новый контрагент</a>
                            </div>

                            <div class="row">


                                <div class="col s12">


                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                            <tr>
                                                <th>Название</th>
                                                <th>БИН/ИИН</th>
                                                <th>Телефон</th>
                                                <th>Адрес, факт.</th>
                                                <th>Прав. сопр.</th>
                                                <th>Действия</th>
                                            </tr>

                                            @foreach($models as $model)
                                                <tr>
                                                    <td>{{$model->companyType ? $model->companyType->name : null}}
                                                        {{$model->company_name_full}}</td>
                                                    <td>{{$model->bin}}</td>
                                                    <td>{{$model->phone}}</td>
                                                    <td>{{$model->fact_address}}</td>
                                                    <td><a href="/projects/{{$project->id}}/contractors/{{$model->id}}/legal-supports"> <i class="fa fa-list" aria-hidden="true"></i></a></td>
                                                    <td>
                                                        <a href="/projects/{{$project->id}}/contractors/{{$model->id}}/edit"> <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        @if(auth()->user()->hasRole('admin'))
                                                            {{ Form::open(array('url' => '/'.$url.'/' . $model->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                                            {{ Form::hidden('_method', 'DELETE') }}
                                                            <button class="btn btn-xs btn-danger delete" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            {{ Form::close() }}
                                                         @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                    {{$models->links()}}


                                </div>


                            </div>
                        </div>





                    </div>
                </div>

            </div>

        </section>
    </div>



@endsection