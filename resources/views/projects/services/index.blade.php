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

                        <div id="orders" class="tab-pane active">
                            <div class="col s12">
                                <a href="/{{$url}}/create" class="btn btn-primary"><i class="fa fa-plus"></i> новая услуга</a>
                            </div>

                            <div class="row">
                                <div class="col s12">
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                            <tr>
                                                <th>Название</th>
                                                <th>Действия</th>
                                            </tr>

                                            @foreach($models as $model)
                                                <tr>
                                                    <td>{{$model->name}}</td>
                                                    <td>
                                                        <a href="/{{$url}}/{{$model->id}}/edit"> <i class="fa fa-pencil" aria-hidden="true"></i></a>
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