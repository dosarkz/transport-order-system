@if($model->exists)
    {{ Form::open(array('url' => secure_url_env('/orders/'.$model->id),'method'=> 'PUT', 'name'=>'updateOrder',
 'class' => 'form-horizontal'))}}
@else
    {{ Form::open(array('url' => secure_url_env('/orders'),'method'=> 'POST', 'name'=>'createOrder',
'class' => 'form-horizontal'))}}
@endif

{{csrf_field()}}
<div class="card-panel">
    <div class="row">
        <div class="input-field col s6">
            {{Form::text('start_point_text', $model->start_point_text, ['id' => 'singleOrderStartPointText'])}}
            <label for="singleOrderStartPointText" class="active">Откуда</label>
        </div>
        <div class="input-field col s6">
            {{Form::text('end_point_text', $model->end_point_text, ['id' => 'singleOrderEndPointText'])}}
            <label for="singleOrderEndPointText" class="active">Куда</label>
        </div>
    </div>

    <div class="row">
        <form class="col s12">
            <div class="row">
                <div class="input-field col s3">
                    {{Form::number('client_price', $model->client_price, ['id' => 'singleOrderClientPrice'])}}
                    <label for="singleOrderClientPrice" class="active">Цена</label>
                </div>
                <div class="input-field col s3">
                    {{Form::text('date_start', $model->date_start, ['id' => 'singleOrderDate'])}}
                    <label for="singleOrderDate" class="active">Дата</label>
                </div>
                <div class="input-field col s6">
                    {{Form::textarea('description', $model->description, ['id' => 'singleOrderDescription', 'class' => 'materialize-textarea'])}}
                    <label for="singleOrderDescription" class="active">Описание</label>
                </div>

            </div>
        </form>
    </div>
    <button type="submit" id="save-changes-button" class="waves-effect waves-light btn">сохранить</button>
</div>

{{Form::close()}}




