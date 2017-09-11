<section class="content">
    <div class="row">
        <div class="col s12">

            <img class="img img-circle" src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_128/{{$transport_category->_image_id}}" />
            {{$transport_category->name}}

        </div>
    </div>

    <div class="row">
        @if($transport->exists)
            {{ Form::open(array('url' => secure_url_env('/driver/transports/'.$transport->id),'method'=> 'PUT', 'name'=>'updateTransport', 'files' => true,
         'class' => 'form-horizontal'))}}

        @else
            <form method="POST" action="/driver/transports" enctype="multipart/form-data">
                @endif

                {{csrf_field()}}
                {{Form::hidden('car_category_id', $transport_category->id)}}

                <div class="row">
                    <div class="col s12">
                        <ul class="tabs" style="width: 100%;">
                            <li class="tab col s3"><a href="#autoparams">Параметры авто</a></li>
                            <li class="tab col s3"><a href="#autodocs">Документы</a></li>
                        </ul>
                    </div>
                </div>

                <div id="autoparams" class="col s12" style="display: block;">
                    <div class="row">
                        <div class="col s12">
                            <div class="col s12 m8">

                                <div class="row">
                                    <div class="col s12"><br>
                                        {{Form::file('transport_images[]',['multiple' => 'multiple',
                                        'class' => 'multi with-preview', 'id' => 'transport_images', ])}}
                                        <label for="transport_images">фото <span class="required">*</span></label>
                                    </div>

                                    <ul class="list-unstyled" id="mycarsUploadedPhotosList">
                                        @foreach($transport->transportImages as $image)
                                            <li>
                                                <div class='col s4'>
                                                    @if($image->image)
                                                    <a href="/{{$image->image->getFullImage()}}" data-type='image' data-toggle='lightbox'>
                                                        <img class="img img-responsive" src="/{{$image->image->getThumb()}}" />
                                                    </a>
                                                        @endif
                                                </div>

                                                <div class="col s2">

                                                    <input type='radio' @if($image->is_main)checked @endif id="radioIsAvatar{{$image->id}}" value='{{$image->id}}' data-id='{{$image->id}}' name='image_on_main' class='radioIsAvatar'>
                                                    <label for="radioIsAvatar{{$image->id}}">На главную</label>

                                                    <a class="btn-floating btn-small waves-effect waves-light red destroy-transport-image"
                                                       data-toggle="modal" data-id="{{$image->id}}" data-target="#confirm"><i class="material-icons">delete</i></a>
                                                </div>

                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <div class="row">

                                            @foreach($transport_category->getCommonFields($transport) as $commonField)
                                                <div class="col m4 s12">
                                                    <label for="">{{$commonField->label}}</label>
                                                    {{$commonField->input}}
                                                </div>
                                            @endforeach

                                        </div>
                                        <!-- include common fields here: -->
                                    </div>

                                    <div class="col s12 m4">
                                        <label for="car_brand_id">Марка авто <span class="required">*</span></label>
                                        {{Form::select('car_brand_id', $transport_brands,$transport->car_brand_id,
                                        ['class' => 'form-control', 'data-category_id' => $transport_category->id,
                                        'id'=> 'car_brand_id', 'placeholder' => 'Марка авто'])}}
                                    </div>

                                    <div class="col s12 m4">
                                        <label for="car_model_type_id">Модель авто</label>
                                        {{Form::select('car_model_type_id', $transport_models,$transport->car_model_type_id, ['class' =>
                                'form-control', 'id'=> 'car_model_type_id', 'placeholder' => 'Модель авто'])}}
                                    </div>



                                    {{--<div class="col m4 s12">--}}
                                        {{--<label for="kind_of_property">вид имущества</label>--}}

                                        {{--{{Form::select('kind_of_property', [1 => 'Частное авто', 2 => 'Авто Unipark'],$transport->kind_of_property, ['class' =>--}}
                                   {{--'form-control', 'id'=> 'kind_of_property', 'placeholder' => 'вид имущества'])}}--}}

                                    {{--</div>--}}
                                </div>

                                <div class="row">
                                    <div class="col s12 m4">
                                        <label for="profileCityId">Город <span class="required">*</span></label>
                                        {{Form::select('city_id', \App\Models\City::orderBy('name_ru','asc')->pluck('name_ru','id'), $transport->city_id,
                                            ['id' => 'profileCityId', 'class' => 'form-control', 'placeholder' => 'Выберите город'])}}
                                    </div>
                                    <!-- год выпуска: -->
                                    <div class="input-field col l4 s12">
                                        {{Form::number('car_production_year_id', $transport->car_production_year_id, ['placeholder' => 'год выпуска',
                                        'id' => 'productionYear'])}}
                                        <label for="productionYear">год выпуска <span class="required">*</span></label>
                                    </div>

                                    <!-- гос номер: -->
                                    <div class="input-field col l4 s12">
                                        {{Form::text('car_gos_number', $transport->car_gos_number, ['placeholder' => 'гос номер',
                                     'id' => 'gosNomer'])}}
                                        <label for="gosNomer">гос номер <span class="required">*</span></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12 m4">
                                        <!-- цена за час: -->
                                        <div class="form-group">
                                            <label class="label label-danger active" for="hourlyPrice">цена за час</label> <span class="required">*</span>
                                            {{Form::number('car_hourly_price', $transport->car_hourly_price, ['placeholder' => '0 тенге за час',
                                          'id' => 'hourlyPrice'])}}
                                        </div>
                                    </div>
                                </div>




                                <!-- доступные услуги для выбранной категории авто: -->

                                <div class="row">

                                    @foreach($transportPrices as $transportPrice)

                                        <div class="col s12 availableServices">

                                            <div class="col s6">
                                                {{Form::checkbox("services[{$transportPrice->service->id}][id]", $transportPrice->service->id,
                                                $transportPrice->checkService($transport), ['class' => 'serviceTransportCategories', 'id' => "service{$transportPrice->service->id}"])}}

                                                <label for="service{{$transportPrice->service->id}}">{{$transportPrice->service->name}}</label>
                                            </div>

                                            <div class="col s6">

                                                @foreach($transportPrice->priceOptions() as $priceOption)
                                                    <div class="input-field col s6">
                                                        {{Form::text("services[{$transportPrice->service->id}][options][{$priceOption->priceOption->id}]",
                                                        $priceOption->getOptionValue($transport), ['id' => "priceOption{$priceOption->id}", 'class' =>
                                                        'servicePriceOption', 'placeholder' => 'цена за'] )}}
                                                        <label for="priceOption{{$priceOption->id}}" class="active">{{$priceOption->priceOption->name}} </label>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                    @endforeach

                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <button type="submit" class="waves-effect waves-light btn" id="editMyCarBtn">
                                                    Сохранить изменения
                                                </button>
                                            </div>
                                            <div class="col-xs-6">
                                                <a class="waves-effect waves-light btn red darken-1" id="cancelCreateWhatever" href="/driver/transport">Отменить изменения</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 col m4">
                            </div>

                        </div>

                    </div>
                </div>
                <div id="autodocs" class="col s12" style="display: none;">
                    <div class="row">
                        <div class="col s12">
                            <div class="col s12">

                                <div class="row box box-primary" id="document_block">
                                    <div class="container-fluid">
                                        <label for="editTransportDocType">Вид документа</label>
                                        {{Form::select('documents[1][document_type]', $document_types,'', ['class' =>
                                                  'form-control', 'id'=> 'document_type', 'placeholder' => 'Вид документа'])}}

                                        <label for="document_expired_at-1">Срок документа</label>
                                        <input id="document_expired_at-1" type="text" name="documents[1][document_expired_at]" class="editTransportDocDate browser-default">
                                        <br>
                                        <input type="file" name="documents[1][document_file]" id="editTransportDocTypeUpload" class="hidden">
                                        <a class="waves-effect waves-light btn red darken-1 editTransportDocTypeUploadBtn">выбрать файл</a>
                                        <div class="row selected_row">
                                            <div id="selected_file"></div>
                                        </div>

                                        <div class="row" id="remove_clone" style="display: none">
                                            <a class="btn btn-info remove_clone_btn" id="remove_clone_btn">Удалить</a>
                                        </div>
                                    </div>
                                </div>

                                <div id="document_block_cloned"></div>

                                <div class="row">
                                    <a class="btn btn-primary" id="add-more-document" >Добавить еще</a>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col s10">
                            <ul>
                                @foreach($transport->transportDocument as $document)
                                    <li>
                                        <a href="#" class="document-delete-btn" data-fileid="{{$document->id}}">
                                            <i class="material-icons">delete</i>
                                        </a>

                                        <a href="/{{$document->url}}" target="_blank" class="document-download-btn" data-fileid="{{$document->id}}">
                                            <i class="material-icons">play_for_work</i>
                                        </a>
                                        {{$document->documentType->name}} - до {{$document->date_to}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>

            </form>
    </div>
        @include('modals.base_modal')
</section>




