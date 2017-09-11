@if($model->exists)
    {{ Form::open(array('url' => secure_url_env('/projects/'.$model->project_id.'/registries/'.$model->id),'method'=> 'PUT',
     'name'=>'updateProjectRegistry', 'class' => 'form-horizontal'))}}
@else
    {{ Form::open(array('url' => secure_url_env('/projects/'.$model->project_id.'/registries'),'method'=> 'POST',
    'name'=>'createProjectRegistry', 'class' => 'form-horizontal'))}}
@endif
{{csrf_field()}}

@if(!$model->exists)
    {{Form::hidden('order_id', request()->input('order_id'))}}
@endif

<div class="row">
    <div class="col s12">
        <div class="input-field col s2">
            <label>Начало</label>
            {{Form::text('start_time', $model->start_time_picker, ['id' => 'date_start_picker'])}}
        </div>

        <div class="input-field col s2">
            <label>Завершение</label>
            {{Form::text('end_time', $model->end_time_picker, ['id' => 'date_end_picker'])}}
        </div>

        <div class="input-field col s2">
            <label>Ед. Изм: @if($model->exists) {{$model->order->priceOption->name}} @endif</label>
            {{Form::number('value', $model->value, ['id' => 'date_end_picker'])}}
        </div>

    </div>

    <div class="col s12">
        <div class="input-field col s4">
            <label for="">Откуда</label>
            {{Form::text('start_point', $model->start_point, ['id' => 'groupOrderStartPoint', 'class' => 'form-control',
            'placeholder' => 'Откуда'])}}
        </div>
        <div class="input-field col s4">
            <label for="">Куда</label>
            {{Form::text('end_point', $model->end_point, ['id' => 'groupOrderEndPoint', 'class' => 'form-control',
            'placeholder' => 'Куда'])}}
        </div>
    </div>

    <div class="col s12 form-group">
        <div class="input-field col s12">
            <label for="">Примечание</label>
            {{Form::textarea('comment_text', $model->comment_text, ['id' => 'description',
            'placeholder' => 'Примечание','class' => 'form-control', 'cols' => 5, 'rows' => 5])}}
        </div>

    </div>
    <div class="col s12 form-group">

        <div class="input-field col s12">
            <label for="">Статус</label>
            {{Form::select('status_id', $model->listStatuses, $model->status_id, ['placeholder' => 'Статус', 'class' =>
            'form-control'])}}
        </div>
    </div>

    <div class="col s12 form-group">
        <div class="col s4">
            <button type="submit" class="btn btn-primary" id="order-form-create-btn">
                @if($model->exists)
                    Обновить
                @else
                    Создать
                @endif
            </button>
        </div>
    </div>
</div>



{{Form::close()}}