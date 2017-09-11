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
                            <h3>Новый оператор</h3>

                           @include('projects.accounts.form')
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
                placeholder: "Выберите пользователя",
                allowClear: true
            });
        });
    </script>
@endsection

