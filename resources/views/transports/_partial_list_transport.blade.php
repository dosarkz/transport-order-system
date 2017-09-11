
    <div class="col-md-12 card green lighten-5 top-buffer transport-card">
        <div class="col-md-3 transport-left-part">

            <a href="/transports/{{$item->id}}{{$item->category}}" class="col-sm-12 rounded-border">
                @if($item->transportImages->first())
                    @if($item->transportImages->first()->_public_image_id)
                        <img class="col-sm-12 rounded-border" src="https://res.cloudinary.com/dzrywvuzd/image/upload/w_200/{{$item->transportImages->first()->_public_image_id}}" alt="">
                    @else
                        @if($img = $item->transportImages()->where('is_main', true)->first())
                            @if($img->image)
                                <img src="/{{$img->image->getThumb()}}" alt="">
                            @endif
                        @else
                            @if($item->transportImages->first())
                                <img src="/{{$item->transportImages->first()->image->getThumb()}}" alt="">
                            @endif
                        @endif
                    @endif
                @else
                    <img class="col-sm-12 rounded-border" src="/img/unipark.png" alt="">
                @endif
            </a>




            <div class="unipark-item-price-container col-sm-12 text-center rounded-border form-group">
                Цена за час: {{$item->car_hourly_price}} тг
            </div>

            @if(auth()->user()->hasRole('admin'))
                <p>
                    <a class="btn btn-primary btn-sm" href="/driver/transports/{{$item->id}}/edit">Редактировать</a>
                </p>
                <p>
                    {{ Form::open(array('url' => '/driver/transports/'.$item->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    <button data-toggle="modal" data-target="#confirm" class="btn btn-xs btn-danger delete" type="button">
                        <i class="fa fa-times" aria-hidden="true"></i> Удалить</button>
                    {{ Form::close() }}
                </p>

            @endif
        </div>
        <div class="col-md-9 transport-right-part">
            <div class="transport-model col-sm-12 text-center rounded-border">

                @if($item->driver and $item->driver->_image_id)
                    <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_48/{{$item->driver ? $item->driver->_image_id : null}}" class="img img-circle offset-s1" >
                @else
                    <img src="/img/unipark.png" class="img img-circle offset-s1" >
                @endif
                {{$item->driver  ? $item->driver->fullName : "Водитель"}}

            </div>
            <h5 class="col-sm-12 text-center top-buffer">
                {{$item->transportCategory->name}} |  {{$item->transportBrand ? $item->transportBrand->name : null}} | {{$item->transportModel ? $item->transportModel->name : null}}
            </h5>
            <p class="col-sm-12">
                Автомобиль {{$item->car_production_year_id}} года производства,
                с гос. номером {{$item->car_gos_number}}.

            </p>
            <p class="pull pull-right">

                @if($item->isFavourite)

                    {{ Form::open(array('url' => '/favourites/'.$item->isFavourite->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                    {{ Form::hidden('_method', 'DELETE') }}

                    <button type="submit" class="btn btn-warning" title="добавить в Избранные"><i class="material-icons">stars</i></button>
                    {{ Form::close() }}
                    @else
                    {{ Form::open(array('url' => '/favourites', 'method' => 'post')) }}
                        {{Form::hidden('transport_id',$item->id)}}
                        <button type="submit" class="btn btn-info" title="добавить в Избранные"><i class="material-icons">stars</i></button>
                    {{ Form::close() }}
                @endif

            </p>
            <p class="pull pull-right">



                <a href="/transports/{{$item->id}}{{$item->category}}">дополнительная информация</a>
            </p>



            <p><b>телефон: </b>

                @if($item->driver)
                    +7{{$item->driver->phone}}
                @endif

            </p>
        </div>
        <div class="col-md-3 transport-user-info">
        </div>
    </div>
