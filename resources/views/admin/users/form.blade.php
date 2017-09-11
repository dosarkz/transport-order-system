@section('css')
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
@endsection

    <div class="row">
        <div class="col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($model->exists)
                {{ Form::open(array('url' => sprintf('/%s/%s',$url, $model->id),'method'=> 'PUT', 'name'=>'update-contest', 'files' => false))}}
            @else
                {{ Form::open(array('url' => sprintf('/%s',$url),'method'=> 'POST', 'name'=>'create-contest', 'files' => false))}}
            @endif

            <div class="box-body">
                <div class="form-group">
                    <label class="control-label" for="title">Имя</label>
                    {{Form::text('first_name', $model->first_name, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    <label class="control-label" for="title">Фамилия</label>
                    {{Form::text('last_name', $model->last_name, ['id' => 'start-at-input', 'class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    <label class="control-label" for="title">Телефон</label>
                    {{Form::text('phone', $model->phone, ['id' => 'stop-at-input', 'class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    <label class="control-label" for="title">Пароль</label>
                    {{Form::password('password', null, ['id' => 'stop-at-input', 'class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    <label class="control-label" for="title">Статус</label>
                    {{Form::select('status_id', [1=> 'Активен', 0 => 'Не активен'], $model->status_id, ['class' => 'form-control'])}}
                </div>

                <br>
                {{ Form::submit('Сохранить') }}
                {{ Form::close() }}
            </div>
        </div>
</div>


@section('js-append')
    <script src="/js/admin/functions.js"></script>
    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/plugins/datepicker/locales/bootstrap-datepicker.ru.js"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker-input').datepicker({
                isRTL: false,
                'format': 'yyyy-mm-dd',
                language: 'ru'
            });
        });
    </script>
@endsection