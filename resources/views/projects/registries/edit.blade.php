@extends('layouts.app')

@section('content')
        <div class="row">

            <section class="content-header">
                <h1>
                    Мои проекты - <a href="/projects/{{$model->project_id}}">{{$model->project->name}}</a>
                    - <a href="/projects/{{$model->project_id}}/registries">Реестры</a>
                    <small>управление проектами</small>
                </h1>
            </section>


            <section class="content">

                <div class="row">
                    <!-- left column -->
                    <div class="col s12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Редактировать реестр на {{$model->start_time}}</h3>
                                <p>Заказ № {{$model->order_id}}</p>
                            </div>
                            <!-- /.box-header -->

                          @include('projects.registries.form')

                        </div>
                    </div>
                </div>

                <br>
                <br>
            </section>

        </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/datetimepicker/bootstrap-datetimepicker.min.css">
@endsection


@section('js-append')
    <script src="/datetimepicker/moment.js"></script>
    <script src="/datetimepicker/moment-ru.js"></script>
    <script src="/datetimepicker/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">

        $('#date_start_picker').datetimepicker({
            format: 'HH:mm'
        });
        $('#date_end_picker').datetimepicker({
            format: 'HH:mm'
        });
    </script>

@endsection