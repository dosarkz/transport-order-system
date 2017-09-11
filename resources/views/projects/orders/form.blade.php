<div class="row">
    @if($model->exists && !request()->has('order_id'))
        {{ Form::open(array('url' => secure_url_env('/projects/'.$project->id.'/orders/'.$model->id),'method'=> 'PUT',
        'name'=>'updateProjectOrder', 'class' => 'form-horizontal'))}}
    @else
        {{ Form::open(array('url' => secure_url_env('/projects/'.$project->id.'/orders'),'method'=> 'POST',
        'name'=>'createProjectOrder', 'class' => 'form-horizontal'))}}
    @endif
    <div class="row">
        <div class="col s12">
            <div class="input-field col s2">
                {{Form::text('date_start', $model->date_start, ['id' => 'date_start_picker'])}}
            </div>

            <div class="input-field col s2">
                {{Form::text('date_end', $model->date_end, ['id' => 'date_end_picker', 'placeholder' => 'Дата завершения'])}}
            </div>

            <div class="input-field col m4 s12">
                {{Form::select('order_service_id',$model->projectServices, $model->order_service_id, ['id' => 'groupOrderServiceId',
               'class' => 'browser-default',  'placeholder' => 'Выберите услугу'])}}
            </div>
        </div>

        <div class="col s12">
            <div class="input-field col s4">
                {{Form::text('start_point_text', $model->start_point_text, ['id' => 'groupOrderStartPoint',
                'placeholder' => 'Откуда'])}}
            </div>
            <div class="input-field col s4">
                {{Form::text('end_point_text', $model->end_point_text, ['id' => 'groupOrderEndPoint',
                'placeholder' => 'Куда'])}}
            </div>
            <div class="input-field col s4">
                {{Form::select('city_id',$model->citiesList, $model->city_id, ['id' => 'groupOrderCityId',
               'class' => 'browser-default',  'placeholder' => 'Выберите услугу'])}}
            </div>
        </div>

    </div>

        <div class="well" id="transport-block">

            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-4">
                        <label for="selectCatId" class="control-label">Вид авто</label>
                        {{Form::select('car_category_id', $transport_categories,$model->car_category_id, ['class' =>
                           'form-control', 'id'=> 'selectCatId', 'style'=> 'width: 100%',
                            'placeholder' => 'Не важно'])}}
                    </div>

                    <div class="col-md-4">
                        <label for="selectMarkaId">Марка авто</label>

                        {{Form::select('car_brand_id', $model->transportBrandsList,$model->car_brand_id, ['class' =>
                       'form-control', 'id'=> 'selectMarkaId', 'style'=> 'width: 100%', 'data-category_id'=> $model->car_category_id,
                       'placeholder' => 'Не важно'])}}
                    </div>

                    <div class="col-sm-4">
                        <label for="selectModelId">Модель авто</label>

                        {{Form::select('car_model_id', $model->transportModelsList, $model->car_model_id, ['class' =>
                    'form-control', 'id'=> 'selectModelId', 'style'=> 'width: 100%',
                    'placeholder' => 'Не важно'])}}
                    </div>
                </div>


            <div class="form-group">
                <div class="col-sm-6">
                    <label for="notificationDrivers">Выберите водителя</label>



                    {{Form::select('car_id', $model->exists ? $model->driversList : [], $model->car_id, [
                    'class' => "form-control", 'id' => 'notificationDrivers', 'data-category_id'=> $model->car_category_id,
                    'data-brand_id' => $model->car_brand_id, 'data-model_id' => $model->car_model_id
                    ])}}
                </div>


                <div class="col-sm-3">
                    <label for="groupOrderCount">Кол. единиц:</label>
                    {{Form::number('amount', $model->amount, ['id' => 'groupOrderCount',
                       'placeholder' => 'Кол. единиц'])}}
                </div>
                <div class="col-sm-3">
                    <label for="groupOrderCarYear">Год:</label>
                    {{Form::number('car_production_year_id', $model->car_production_year_id, ['id' => 'groupOrderCarYear',
                      'placeholder' => 'Год'])}}
                </div>
            </div>

                {{--<div class="form-group col-sm-6">--}}
                    {{--<a class="btn btn-info pull-left" id="add-auto">Добавить</a>--}}
                {{--</div>--}}

            </div>


            {{--<div id="list_drivers">--}}
                {{--@if($model->exists)--}}
                    {{--<div class="form-group well white">--}}
                        {{--<p>Поставщики:</p>--}}
                        {{--<ul>--}}
                            {{--@foreach($model->drivers as $driver)--}}
                                {{--<li>Поставщик: {{$driver->transportInfo}}</li>--}}
                             {{--@endforeach--}}
                        {{--</ul>--}}
                        {{--<p>--}}
                            {{--<a class="btn btn-warning" id="remove-clone-btn">Удалить</a>--}}
                        {{--</p>--}}
                    {{--</div>--}}
               {{--@endif--}}
            {{--</div>--}}


        </div>

    <div class="col s12 form-group">

        <div class="col s12 form-group">
            <label for="groupContragentId">Заказчик</label><br>

            {{Form::select('contractor_id', $contractorsList,$model->contractor_id, ['class' =>
                      'form-control', 'id'=> 'groupContragentId', 'style'=> 'width: 100%',
                       'placeholder' => 'Не важно'])}}
        </div>

        <div class="col s4">
            <label for="ContragentDocType">Правовое сопровождение</label>

            {{Form::select('client_document_type', $contractorDocTypesList, $model->client_document_type, ['class' =>
                      'form-control', 'id'=> 'ContragentDocType', 'style'=> 'width: 100%',
                       'placeholder' => 'Не важно'])}}

        </div>

        <div class="col s6 form-group">
            <label for="ContragentDocFiles">Список</label>

            {{Form::select('contractor_document_id', [],'', ['class' =>
                     'form-control', 'id'=> 'ContragentDocFiles', 'style'=> 'width: 100%',
                      'placeholder' => 'Нет файлов'])}}

        </div>

    </div>

    <div class="col s12">

        <div class="groupOrderContactContainer" id="groupOrderContactContainer">
            <div class="col s8">
                @if($model->exists)
                    @if($model->phones->count() == 0)
                        {{Form::text('phones[]', '', ['id' => 'groupOrderCarYear', 'class' =>
                     'form-control groupOrderContactField', 'placeholder' => 'контакты'])}}
                        @endif

                    @foreach($model->phones as $phone)
                        {{Form::text('phones[]', $phone->phone, ['id' => 'groupOrderCarYear', 'class' =>
                'form-control groupOrderContactField', 'placeholder' => 'контакты'])}}
                    @endforeach
                @else
                    {{Form::text('phones[]', '', ['id' => 'groupOrderCarYear', 'class' =>
                      'form-control groupOrderContactField', 'placeholder' => 'контакты'])}}
                @endif
            </div>
            <div class="col s4">
                <a class="btn btn-info groupOrderContactAddBtn"><i class="tiny material-icons">add</i></a>
                <a class="btn btn-warning groupOrderContactDeleteBtn hidden"><i class="tiny material-icons">delete</i></a>
            </div>
        </div>

        <div id="contacts-cloned"></div>

    </div>

    <div class="col s12 form-group">
        <div class="col s2">
            <label for="groupOrderTarif">Ед.изм.</label>:

            {{Form::select('tariff_id', $priceOptionsList, $model->tariff_id, ['id' => 'groupOrderTarif', 'class' =>
             'form-control', 'placeholder' => 'Тариф'])}}

        </div>
        <div class="input-field col s3">

            {{Form::text('client_price', $model->client_price, ['id' => 'groupOrderPrice', 'class' =>
               'form-control', 'placeholder' => '0'])}}
            <label for="groupOrderPrice">Цена за 1ед (Заказчика)</label>
        </div>
        <div class="input-field col s3">
            {{Form::text('driver_price', $model->driver_price, ['id' => 'groupOrderDriverPrice', 'class' =>
             'form-control', 'placeholder' => '0'])}}
            <label for="groupOrderDriverPrice">Цена за 1ед (Поставщика)</label>
        </div>
        <div class="input-field col s12">
            <label for="groupOrderComment">Примечание</label>
            {{Form::textarea('description', $model->description, ['id' => 'groupOrderComment', 'class' =>
          'form-control', 'placeholder' => 'примечание', 'rows' => 4,  'cols' => 40])}}

        </div>

    </div>

    <div class="col s12 form-group">
        <div class="col s4">
            <button type="submit" class="btn btn-primary" id="order-form-create-btn">
                @if($model->exists && !request()->has('order_id'))
                    Обновить
                @else
                    Создать
                @endif
            </button>
        </div>
    </div>

    {{Form::close()}}
</div>