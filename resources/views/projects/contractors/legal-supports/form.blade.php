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
                {{ Form::open(array('url' => sprintf('%s/%s',$url, $model->id),'method'=> 'PUT', 'name'=>'update-contest', 'files' => true))}}
            @else
                {{ Form::open(array('url' => secure_url_env($url),'method'=> 'POST', 'name'=>'create-contest', 'files' => true))}}
            @endif

            <div class="box-body">


                <div class="row">
                    <div class="row">
                        <div class="input-field col m5 s12">

                            {{Form::select('file_type', \App\Models\ContractorFileType::pluck('name','id'), $model->file_type,
                       ['class' => 'browser-default', 'placeholder' => 'вид документа'])}}

                        </div>

                        <div class="input-field col m3 s12">
                            {{Form::number('file_number', $model->file_number, ['id' => 'projectCompanyField',
                       'placeholder' => '№ документа'])}}
                            <label for="fileNumber" class="active">№ документа</label>
                        </div>


                        <div class="input-field col m3 s12">
                            {{Form::number('file_price', $model->file_price, ['id' => 'projectCompanyField',
                      'placeholder' => 'Сумма,тнг'])}}
                            <label for="filePrice" class="active">Сумма,тнг</label>
                        </div>

                        <div class="input-field col m3 s12">
                            <label for="fileStartDate" class="active">Начало</label>
                            {{Form::text('start_at', $model->start_at, ['id' => 'fileStartDate',
                      'placeholder' => 'Начало'])}}

                            {{Form::hidden('contractor_id', $contractor->id)}}
                            {{Form::hidden('project_id', $project->id)}}

                        </div>
                        <div class="input-field col m3 s12">
                            <label for="fileEndDate" class="active">Завершение</label>
                            {{Form::text('stop_at', $model->stop_at, ['id' => 'fileEndDate',
                     'placeholder' => 'Завершение'])}}

                        </div>


                        <div class="input-field col m3 s12">
                            {{Form::text('file_type_name', $model->file_type_name, ['id' => 'projectCompanyField',
                       'placeholder' => 'Название файла'])}}
                            <label for="file_name" class="active">Название файла</label>
                        </div>
                        <div class="col s12 form-group">
                            <label for="file" class="active">Файл</label>
                                {{Form::file('file_id', ['id' => 'file'])}}



                        </div>

                        @if($model->file)
                            <div class="form-group col s12">
                               <p>Загруженный файл:  <a target="_blank" href="{{$model->file->getFile()}}">Файл</a>

                               </p>
                            </div>
                        @endif
                        <div class="input-field col m12 s12">

                            <label for="fileDescription" class="">Описание</label>
                            {{Form::textarea('description', $model->description, ['id' => 'fileDescription', 'class' =>
                            'form-control',
                    'placeholder' => 'Описание'])}}


                        </div>


                    </div>
                <br>
                {{ Form::submit($model->exists ?  'Обновить' : 'Сохранить',['class' => 'btn btn-success']) }}
                {{ Form::close() }}
        </div>
</div></div></div>


@section('js-append')
    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/plugins/datepicker/locales/bootstrap-datepicker.ru.js"></script>
    <script>
        $(document).ready(function() {
            $('#fileStartDate').datepicker({
                isRTL: false,
                'format': 'yyyy-mm-dd',
                language: 'ru'
            });

            $('#fileEndDate').datepicker({
                isRTL: false,
                'format': 'yyyy-mm-dd',
                language: 'ru'
            });
        });
    </script>
@endsection