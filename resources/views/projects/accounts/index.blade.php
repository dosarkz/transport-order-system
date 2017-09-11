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
                            <div id="accounts" class="tab-pane active">
                                <a class="btn btn-primary" href="/projects/{{$project->id}}/accounts/create">Добавить</a>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Фамилия</th>
                                    <th>Телефон</th>
                                    <th>Должность</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>

                               @foreach($accounts as $account)
                                    <tr>
                                        <td>{{$account->user->first_name}} </td>
                                        <td>{{$account->user->last_name}}</td>
                                        <td>{{$account->user->phone}}</td>
                                        <td>{{$account->post}}</td>
                                        <td>
                                            {{ Form::open(array('url' => '/projects/' . $project->id.'/accounts/'.$account->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <button class="btn btn-xs btn-danger delete" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                   @endforeach

                            </table>

                        </div>

                    </div>
                </div>

            </section>

        </div>



@endsection



@section('js-append')
    <script>
        $(document).ready(function() {




            $("#user").select2({
                placeholder: "Выберите услугу",
                allowClear: true
            });


        });


    </script>
@endsection

