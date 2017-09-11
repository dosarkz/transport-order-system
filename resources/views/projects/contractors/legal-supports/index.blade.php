@extends('layouts.app')

@section('content')



    <div class="row">


        <section class="content-header">
            <h1>
                Мои проекты - <a href="/projects/{{$project->id}}">{{$project->name}}</a>
                -- <a href="/projects/{{$project->id}}/contractors">Контрагенты</a>
                <small>управление проектами</small>
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
                            <div class="col s12 form-group">
                                <h3>{{$contractor->company_name_full}}</h3>

                                <a href="/projects/{{$project->id}}/contractors/{{$contractor->id}}/legal-supports/create" class="btn btn-primary"><i class="fa fa-plus"></i> новый документ</a>
                            </div>

                            <div class="row">


                                <div class="col s12">


                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tbody>
                                            <tr>
                                                <th>Название</th>
                                                <th>Срок действия</th>
                                                <th>Сумма,тнг</th>
                                                <th>Примечание</th>
                                                <th>Создано</th>
                                                <th>Файл</th>
                                                <th>Действия</th>
                                            </tr>

                                            @foreach($models as $model)
                                                <tr>
                                                    <td>{{$model->file_type_name}}</td>
                                                    <td>{{$model->stop_at}}</td>
                                                    <td>{{$model->file_price}}</td>
                                                    <td>{{$model->description}}</td>
                                                    <td>{{$model->created_at}}</td>
                                                    <td><a href="{{$model->file ? $model->file->getFile() : null}}">Файл</a></td>
                                                    <td><a href="/projects/{{$project->id}}/contractors/{{$contractor->id}}/legal-supports/{{$model->id}}/edit"> <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        @if(auth()->user()->hasRole('admin'))
                                                            {{ Form::open(array('url' => '/'.$url.'/' . $model->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                                            {{ Form::hidden('_method', 'DELETE') }}
                                                            <button data-toggle="modal" data-target="#confirm" class="btn btn-xs btn-danger delete" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
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


    @include('modals.base_modal')
@endsection

@section('js-append')
    <script>
        $(document).ready(function() {
            $('form.form-delete').on('click', function (e) {
                var form = $(this);

                $(document).on('click', '#delete-btn', function () {
                    form.submit();
                });
            });
        });
    </script>
@endsection
