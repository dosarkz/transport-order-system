<div class="card green lighten-5">
    <div class="card-content">

        <a href="/orders/{{$order->id}}">
            <span class="card-title activator grey-text text-darken-4 myorders-card-title">заказ #{{$order->id}}<i class="material-icons right">more_vert</i></span>
        </a>
        <div class="row">
            <div class="order-left-part col s4">
                <img data-startpoint="Отель радисон " data-endpoint="по городу " class="mg-mini-map col s12" src="https://maps.googleapis.com/maps/api/staticmap?center=51.0330155,69.8732136&amp;zoom=4&amp;size=300x200&amp;key=AIzaSyDkLcB-e6TsLztuLPrzKpxLb0iZvotTffk" data-id="3701">
            </div>
            <div class="order-right-part col s8">
                <div class="col s12 order-name-status"  data-id="{{$order->id}}">
                    #{{$order->id}} @if($order->status)<span>{{$order->status->status_text}}</span>@endif

                    @if($order->transport && $order->transport->driver)
                        <div class="col s2 driver-image-holder">
                            @if($order->transport->driver->_image_id)
                                <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_48/{{$order->transport->driver ? $order->transport->driver->_image_id : null}}" class="img img-circle offset-s1" >
                            @else
                                <img src="/img/icon_160.png" class="img img-circle z-depth-3">
                            @endif

                        </div>
                        <div class="col s3">
                            <div>{{$order->transport->driver->fullName}} </div>
                        </div>
                        <div class="col s4">
                            <div>{{$order->transport->car_gos_number}} </div>

                        </div>
                    @endif
                </div>


                <div class="col s9">
                    <a href="/orders/{{$order->id}}">

                        <div class="col s12 top-buffer">
                            <span class="price-date-timer">
                                @if($order->service)
                                    <div class="form-group">
                                        <label for="">Вид услуги:</label>
                                        {{$order->service->name}}
                                    </div>
                                @endif

                                @if($order->transportCategory)
                                    <div class="form-group">
                                        <label for="">Вид транспорта:</label>
                                        {{$order->transportCategory->name}}
                                    </div>
                                @endif
                            </span>

                            <p>
                                @if($order->transport)
                                    {{$order->transport->transportCategory->name}} |  {{$order->transport->transportBrand ? $order->transport->transportBrand->name : null}} | {{$order->transport->transportModel ? $order->transport->transportModel->name : null}}
                                @endif
                            </p>
                        </div>

                        <div class="col s12">{{$order->start_point_text}} - {{$order->end_point_text}}</div>

                        <div class="order-description top-buffer col s12">{{$order->description}}</div>


                        <div class="col s5 price-date-timer">
                            <i class="fa fa-clock-o icon-color"></i> {{$order->date_start}}
                        </div>

                        <div class="col s3 price-date-timer">
                            <i class="fa fa-comment icon-color"></i> {{$order->transportRequests->count()}}
                        </div>
                        <div class="col s12 price-date-timer" style="font-size:2em;">
                            <span class="icon-color">&#8376;</span> {{$order->client_price ? $order->client_price : 0}}
                        </div>
                    </a>
                </div>
                <div class="col s3">

                    <div class="row">

                        {{ Form::open(array('url' => '/orders/'. $order->id, 'class' => 'form-delete', 'style' => 'display:inline;')) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        <a href="#" class="deleteMyOrderBtn" data-orderid="{{$order->id}}" ><i class="material-icons">delete</i> удалить</a>
                        {{ Form::close() }}
                    </div>
                    <div class="row">
                        <a href="/orders/{{$order->id}}" class=""><i class="material-icons">mode_edit</i> Изменить</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card-reveal">
        <span class="card-title grey-text text-darken-4">заказ #{{$order->id}}<i class="material-icons right">close</i></span>
        <p>{{$order->description}}</p>
    </div>
</div>