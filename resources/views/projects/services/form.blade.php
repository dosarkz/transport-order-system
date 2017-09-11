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
            {{ Form::open(array('url' => sprintf('%s/%s',$url, $model->id),'method'=> 'PUT', 'name'=>'update-contest', 'files' => false))}}
        @else
            {{ Form::open(array('url' => secure_url_env($url),'method'=> 'POST', 'name'=>'create-contest', 'files' => false))}}
        @endif

        <div class="box-body">
            <div class="row">
                <div class="input-field col s8">
                    <label for="projectCompanyField" class="active">Наименование услуги</label>
                    {{Form::text('name', $model->name, ['id' => 'name',
                    'placeholder' => 'название'])}}

                </div>
            </div>

            {{Form::hidden('project_id', $project->id)}}

            <br>
            {{ Form::submit($model->exists ?  'Обновить' : 'Сохранить',['class' => 'btn btn-success']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>

