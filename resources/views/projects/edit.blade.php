@extends('layouts.app')

@section('content')
        <div class="row">

            <section class="content-header">
                <h1>
                    Мои проекты
                    <small>управление проектами</small>
                </h1>
            </section>


            <section class="content">

                <div class="row">
                    <!-- left column -->
                    <div class="col s12 m8">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Редактировать проект</h3>
                            </div>
                            <!-- /.box-header -->

                          @include('projects.form')

                        </div>
                    </div>
                </div>

                <br>
                <br>
            </section>

        </div>
@endsection

@section('js-append')


@endsection