@extends('layouts.app')

@section('content')
    <div class="row">

        <section class="content-header">
            <h1>
                Мои проекты - <a href="/projects/{{$project->id}}">{{$project->name}}</a> -
                <a href="/projects/{{$project->id}}/orders/{{$order->id}}">Заказ #{{$order->id}}</a>
                <small>управление проектами</small>
            </h1>
        </section>


        <section class="content">

            <div class="row">
                <!-- left column -->
                <div class="col s12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Запросы от водителей</h3>
                        </div>
                        <!-- /.box-header -->



                        <div class="row">
                            <table class="table table-condensed">
                                @foreach($order->transportRequests as $request)



                                        <tr>
                                            <td>
                                                <div class="col m3 s12">
                                                    <img src="https://res.cloudinary.com/dzrywvuzd/image/upload/w_120/{{$request->transport->driver->_image_id}}" width="120px" class="img img-thumbnail">
                                                    <br>
                                                    <a href="/orders/{{$order->id}}/confirm-a-driver-request/{{$request->id}}"  class="btn btn-primary" >Выбрать</a>
                                                </div>
                                                <div class="col m3 s12">
                                                    <div>{{$request->transport->driver->fullName}}</div>
                                                    <div>+7{{$request->transport->driver->phone}}</div>
                                                    <div>  <span class="icon-color">&#8376;</span> {{$request->price}}</div>
                                                </div>

                                                <div class="col m3 s12">

                                                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                        <!-- Indicators -->
                                                        <ol class="carousel-indicators">
                                                            @foreach($request->transport->transportImages as $key => $image)
                                                                <li data-target="#myCarousel" data-slide-to="{{$key}}" @if($key == 0)class="active" @endif></li>
                                                            @endforeach

                                                        </ol>

                                                        <!-- Wrapper for slides -->
                                                        <div class="carousel-inner">

                                                            @if($request->transport->transportImages)

                                                                @if($request->transport->transportImages->count() == 0)
                                                                    <div class="item active">

                                                                        <img src="/img/icon_512.png" alt="slide pic" style="margin-left:5em;" width="300">
                                                                    </div>
                                                                @endif

                                                                @foreach($request->transport->transportImages as $key => $transportImage)

                                                                        <div class="item {{$key == 0 ? 'active' : null}}">

                                                                            <a href="/{{$transportImage->image->getFullImage()}}" data-lightbox="image-{{$key}}" data-title="{{$request->transport->transportBrand ? $request->transport->transportBrand->name : null}} - {{$request->transport->car_gos_number}}">
                                                                                <img src="/{{$transportImage->image->getFullImage()}}" alt="">
                                                                            </a>
                                                                        </div>
                                                                @endforeach

                                                            @endif


                                                        </div>

                                                        <!-- Left and right controls -->
                                                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>

                                                </div>
                                                <div class="col m3 s12">
                                                    <div>{{$request->transport->transportBrand ? $request->transport->transportBrand->name : null}} |
                                                        {{$request->transport->transportModel ? $request->transport->transportModel->name : null}}
                                                        {{ $request->transport->car_gos_number}}
                                                    </div>
                                                    <div>Вид: {{$request->transport->transportCategory->name}} </div>
                                                    <div>Год выпуска: {{$request->transport->car_production_year_id}} г</div>
                                                    <div>Город:  {{$request->transport->city->name}} </div>
                                                </div>
                                            </td>
                                        </tr>
                                @endforeach

                                </table>
                        </div>

                    </div>
                </div>
            </div>

            <br>
            <br>
        </section>

    </div>
@endsection

