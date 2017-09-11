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
                            <li class="active"><a data-toggle="tab" href="#transports" aria-expanded="false">Транспорт</a></li>
                        </ul>
                        <div class="tab-content">


                            <div id="transports" class="tab-pane active">
                                <div class="row">

                                    @foreach($transportCategories as $transportCategory)

                                        <div class="col s12 m6">
                                            <a href="/transports?category_id={{$transportCategory->id}}{{append_city()}}" class="transport-category-link">
                                                <div class="card-panel grey lighten-5 z-depth-1 valign">
                                                    <div class="row valign-wrapper">
                                                        <div class="col s2">
                                                            <img class="gray circle responsive-img" src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_120/{{$transportCategory->_image_id}}">
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

                <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                    <a class="btn-floating btn-large red" href="/driver/transports/choose-category">
                        <i class="primary material-icons">add</i>
                    </a>
                </div>


            </section>
            <!-- /.content -->

        </div>

@endsection