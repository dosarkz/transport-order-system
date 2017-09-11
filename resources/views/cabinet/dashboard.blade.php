@extends('layouts.app')

@section('content')
        <div class="row">
        <section class="content-header">

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="col-md-12 col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#services" aria-expanded="true">Услуги</a></li>
                        <li class=""><a data-toggle="tab" href="#transports" aria-expanded="false">Транспорт</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="services" class="tab-pane active">
                            <div class="row">

                               @foreach($services as $service)

                                    <div class="col s12 m6 dashboard-service">
                                        <a href="/transports?service_id={{$service->id}}{{append_city()}}" class="transport-category-link">
                                            <div class="card-panel grey lighten-5 z-depth-1 valign">
                                                <div class="row valign-wrapper">
                                                    <div class="col s2">
                                                        <img class="circle responsive-img" src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_120/{{$service->_image_id}}">
                                                    </div>
                                                    <div class="col s10">
                                                        <span class="flow-text">{{$service->name}} ({{$service->countTransportServicesByCity()}})</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                               @endforeach



                            </div>
                        </div>

                        <div id="transports" class="tab-pane">
                            <div class="row">

                                @foreach($transportCategories as $transportCategory)

                                    <div class="col s12 m6">
                                        <a href="/transports?category_id={{$transportCategory->id}}{{append_city()}}" class="transport-category-link">
                                            <div class="card-panel grey lighten-5 z-depth-1 valign">
                                                <div class="row valign-wrapper">
                                                    <div class="col s2">
                                                        <img class="circle responsive-img" src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_120/{{$transportCategory->_image_id}}">
                                                    </div>
                                                    <div class="col s10">
                                                        <span class="flow-text">{{$transportCategory->name}} ({{$transportCategory->countTransportServicesByCity()}})</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                @endforeach




                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div id="providers" class="tab-pane">

                        </div>

                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>


        </section>
        <!-- /.content -->

        </div>
@endsection