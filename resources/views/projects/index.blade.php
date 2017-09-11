@extends('layouts.app')

@section('content')
    <div class="row">


        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Список проектов</h3>
                        </div>
                        <div class="box-body table-responsive">

                            <div class="row">
                                <div class="col-md-11">

                                    <table class="table">
                                        <thead class="thead-inverse">
                                        <tr>
                                            <th>Название проекта</th>
                                            <th>Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($model as $item)

                                            <tr>
                                                <td><a href="/projects/{{ $item->id }}">{{$item->name}}</a></td>
                                                <td>
                                                    <a  class="btn btn-xs btn-info" href="/projects/{{ $item->id }}">Перейти</a>
                                                    <a  class="btn btn-xs btn-primary" href="/projects/{{ $item->id }}/edit">редактировать</a>


                                                    {{ Form::open(array('url' => '/projects/'.$item->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}
                                                    <button data-toggle="modal" data-target="#confirm" class="btn btn-xs btn-danger delete" type="button">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Удалить</button>
                                                    {{ Form::close() }}

                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>



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