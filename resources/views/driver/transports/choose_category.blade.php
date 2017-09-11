@extends('layouts.app')

@section('content')

        <div class="row">

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s3"><a class="active" href="#newauto">Регистрация авто</a></li>
                        </ul>
                    </div>
                    <div id="newauto" class="col s12">
                        <div class="row">
                            @foreach($transport_categories as $transport_category)
                                <div class="col s12 m6">
                                    <a href="/driver/transports/create?category_id={{$transport_category->id}}" class="transport-category-link">
                                        <div class="card-panel grey lighten-5 z-depth-1 valign">
                                            <div class="row valign-wrapper">
                                                <div class="col s2">
                                                    <img class="gray circle responsive-img"
                                                         src="https://res.cloudinary.com/dzrywvuzd/image/upload/h_120/{{$transport_category->_image_id}}" />
                                                </div>
                                                <div class="col s10">
                                                    <span class="flow-text">
                                                      {{$transport_category->name}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </section>

        </div>

@endsection