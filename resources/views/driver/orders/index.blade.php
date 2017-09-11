@extends('layouts.app')

@section('content')
        <section class="row">

            <section class="content-header">
                <h1>Мои Заказы</h1>
            </section>

            <section class="content">
                <div class="row">

                    <div class="col s12">
                        <ul class="nav nav-tabs">
                            <li class="tab col s3 active"><a data-toggle="tab" href="#freeorders">Свободные заказы</a></li>
                            <li class="tab col s3"><a data-toggle="tab" href="#orders">Мои заказы</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="freeorders" class="col s12 tab-pane active">

                            @foreach($orders as $order)
                                <div class="card green lighten-5" style="overflow: hidden;">
                                    <div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4">заказ #{{$order->id}}<i class="material-icons right">more_vert</i></span>
                                        <div class="row">
                                            <img data-startpoint="Отель радисон " data-endpoint="по городу " class="order-left-part col s4 img-mini-map" src="https://maps.googleapis.com/maps/api/staticmap?center=51.0330155,69.8732136&amp;zoom=4&amp;size=300x200&amp;key=AIzaSyDkLcB-e6TsLztuLPrzKpxLb0iZvotTffk" data-id="3701">
                                            <div class="order-right-part col s8">
                                                <div class="col s12 order-name-status">
                                                    @if($order->user)
                                                    <div class="driver-image-holder col s2">

                                                            <img class="img img-circle offset-s1e" src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_48/{{$order->user->_image_id}}" alt="User profile picture">


                                                    </div>

                                                    <span class="col s3">{{$order->user->fullName}}</span>

                                                    @endif

                                                    <i class="fa fa-clock-o icon-color"> </i> {{$order->created_at}}


                                                </div>
                                                <div class="col s12 top-buffer">
                                                <span class="price-date-timer">
                                                {{$order->service ? $order->service->name : null}}
                                                    @if($order->transport)
                                                        {{$order->transportCategory ? $order->transportCategory->name : null}}
                                                    @endif

                                                </span>
                                                    <p>

                                                        @if($order->transport)
                                                            {{$order->transport->transportCategory ? $order->transport->transportCategory->name : null}} |  {{$order->transport->transportBrand ? $order->transport->transportBrand->name : null}} | {{$order->transport->transportModel ? $order->transport->transportModel->name : null}}
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="col s12">{{$order->description}}</div>


                                                <div class="order-description top-buffer col s12"></div>
                                                @if($order->user)
                                                <div class="col s4">
                                                    <a class="btn btn-warning waves-effect waves-light">+7 {{$order->user->phone}}</a>
                                                </div>
                                                @endif

                                                <div class="col s4">
                                                    @if($order->hasRequest)
                                                        <a class="btn btn-primary waves-effect waves-light" data-url="/driver/orders/{{$order->id}}/cancel-request/{{$order->hasRequest->id}}"
                                                           data-toggle="modal" data-target="#cancel_order_modal">Отменить заказ</a>
                                                    @else
                                                        <a class="btn btn-warning waves-effect waves-light" data-order_id="{{$order->id}}" data-toggle="modal" data-target="#pick_up_order_modal">забрать заказ</a>
                                                    @endif
                                                </div>

                                                <div class="col s4">
                                                    <p>Статус: {{$order->status ? $order->status->status_text : null}}</p>
                                                </div>
                                                <div class="col s12 price-date-timer" style="font-size:2em;">
                                                    <span class="icon-color">₸</span> {{$order->client_price ? $order->client_price : 0}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            @endforeach

                            {{$orders->links()}}


                        </div>
                        <div id="orders" class="col s12 tab-pane">



                        </div>


                    </div>
                </div>
            </section>
        </section>

    @include('modals.pick_up_order_modal')
    @include('modals.cancel_order_modal')
@endsection

@section('js-append')
    <script>
        $(document).ready(function() {
            $('.js-modalMyOrdersOpenForm').click(function (e) {
                e.preventDefault();
                $('#modalMyOrdersCreate').modal('show');
            });

            $('.deleteMyOrderBtn').on('click', function(e){
                e.preventDefault();
                var $form=  $('.form-delete');
                $('#confirm').modal({ backdrop: 'static', keyboard: false })
                        .on('click', '#delete-btn', function(){
                            $form.submit();
                        });
            });

            $('#car_id').select2({
                placeholder: "Выберите авто",
                allowClear: true
            });

            $('#pick_up_order_modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var order_id = button.data('order_id');
                var modal = $(this);
                modal.find('.modal-body input#pick_up_order_id').val(order_id)
            });

            $('#cancel_order_modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);
                modal.find('.modal-footer a#yes-cancel-modal-btn').attr('href', url);
            });

            $("#pick_up_order_btn").click(function(e)
            {
                e.preventDefault();
                this.parentElement.parentElement.submit();
            });


        });



    </script>

@endsection