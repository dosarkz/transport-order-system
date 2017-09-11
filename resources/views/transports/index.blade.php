@extends('layouts.app')

@section('content')
        <div class="row">

            <section class="content-header center-align">
                <h4 class="header">Поиск - {{$service->name}}</h4>
            </section>

            <!-- Main content -->
            <section class="content">
                <h3></h3>
                <div class="row center-align">
                    <span><a class="btn btn-large waves-effect waves-light col s4 darken-4 chooseFormOpen">отбор</a></span>
                    @if(request()->has('service_id'))
                    <span><a data-toggle="modal" data-target="#new-order-modal" data-service_id="{{$service->id}}"
                             class="btn btn-large col s4 offset-s1 waves-effect waves-light yellow darken-4"><i class="fa fa-mouse-pointer"></i> запрос</a></span>
                    @endif

                    @if(request()->has('category_id'))
                        <span><a data-toggle="modal" data-target="#new-order-modal" data-category_id="{{$service->id}}"
                                 class="btn btn-large col s4 offset-s1 waves-effect waves-light yellow darken-4"><i class="fa fa-mouse-pointer"></i> запрос</a></span>
                    @endif
                </div>

                <div style="display:none;" id="chooseForm" class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card green lighten-5">
                                <form action="/transports" method="GET">
                                    {{--{{csrf_field()}}--}}
                                    @if(request()->has('service_id'))
                                    {{Form::hidden('service_id',request()->get('service_id'))}}
                                    @else
                                        {{Form::hidden('category_id',request()->get('category_id'))}}
                                    @endif


                                    <div class="card-content">
                                        <div class="row">
                                            <span class="card-title">Параметры отбора</span>
                                        </div>
                                    </div>
                                    <!-- card search panel start-->
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="form-group col-md-4 s12">
                                                <label for="selectCatId">Вид авто</label>

                                                {{Form::select('transport-category', $transport_categories,'', ['class' =>
                                                'form-control select2 select2-hidden-accessible', 'id'=> 'selectCatId', 'style'=> 'width: 100%',
                                                'placeholder' => 'Не важно'])}}
                                            </div>
                                            <div class="form-group col-md-4 s12">
                                                <label for="selectMarkaId">Марка авто</label>

                                                {{Form::select('transport-brand', $transport_brands,'', ['class' =>
                                               'form-control select2 select2-hidden-accessible',
                                               'data-category_id' => request()->input('transport-category'),
                                               'id'=> 'selectMarkaId', 'style'=> 'width: 100%',
                                               'placeholder' => 'Не важно'])}}

                                            </div>

                                            <div class="form-group col-md-4 s12">
                                                <label for="selectModelId">Модель авто</label>

                                                {{Form::select('transport-model', $transport_models,'', ['class' =>
                                            'form-control select2 select2-hidden-accessible', 'id'=> 'selectModelId', 'style'=> 'width: 100%',
                                            'placeholder' => 'Не важно'])}}
                                            </div>

                                            <div class="col-md-4 s12">
                                                <div class="form-group">
                                                    <input type="text" id="carProductionYear" name="production-year" value="{{request()->get('production-year')}}" class="form-control" placeholder="Год выпуска">
                                                </div>
                                            </div>

                                            <div class="col-md-4 s12">
                                                <div class="form-group">
                                                    <input type="text" id="carGosNomerValue" value="{{request()->get('gos-number')}}" name="gos-number" class="form-control" placeholder="Гос номер">
                                                </div>
                                            </div>


                                            <div class="col-md-4 s12">
                                                <div class="form-group">
                                                    <input type="text" id="fio" value="{{request()->get('fio')}}" name="fio" class="form-control" placeholder="Фамилия или имя">
                                                </div>
                                            </div>

                                            <div class="col-md-4 s12">
                                                <div class="form-group">
                                                    <input type="text" id="phone" value="{{request()->get('phone')}}" name="phone" class="form-control" placeholder="Телефон">
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="card-action">
                                        <div class="row">
                                            найдено: {{$model->count()}} элементов
                                            <div class="col-md-12 col-md-offset-8">
                                                @if(request()->has('category_id'))
                                                    <a class="btn btn-info" href="/transports?category_id={{$service->id}}">Сбросить</a>
                                                @else
                                                    <a class="btn btn-info" href="/transports?service_id={{$service->id}}">Сбросить</a>
                                               @endif
                                                <button type="submit" class="waves-effect waves-light btn" id="searchBtn"><i class="material-icons left">search</i>поиск</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- search card panel end -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-warning">




                        <div class="col-md-12">



                                {{$model->appends(request()->all())->links()}}

                                @foreach($model as $item)
                                    @include('transports._partial_list_transport')
                                @endforeach


                        </div>
                        {{$model->appends(request()->all())->links()}}

                    </div>
                </div>


            </section>
            <!-- /.content -->


        @include('modals.new_order')
        @include('modals.base_modal')


        </div>
@endsection

@section('js')
@endsection

@section('css')
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
    {{--<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.css">
@endsection


@section('js-append')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.js"></script>
    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>



    <script>
        $(document).ready(function() {

            $('form.form-delete').on('click', function (e) {
                var form = $(this);

                $(document).on('click', '#delete-btn', function () {
                    form.submit();
                });
            });

        });
    </script>


    <script>

        $(document).ready(function(){
            $("#orderSendBtn").click(function(e,t) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: '/ajax/new-order',
                    data: $("form#new-order").serialize(),
                    success: function(data) {
                        $.notify('Ваш заказ '+data.order.id+' успешно создан',null, null, 'success');
                        $('.modal-close').click();
                        $("form#new-order")[0].reset();
                    },
                    error: function(jqXHR,code, exception) {
                        displayFieldErrors(jqXHR);
                    }
                })
            });


            $('#new-order-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var service_id = button.data('service_id');
                var category_id = button.data('category_id');
                var modal = $(this);
                modal.find('div#category_id').remove();

                if(service_id != null)
                {
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = 'service_id';
                    input.value = service_id;
                    modal.find('.modal-body').append(input);
                    modal.find('form').attr('action', '/orders?type=service');
                    modal.find('.modal-title').text('Новый заказ в услуге');
                }

                if(category_id != null)
                {
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = 'category_id';
                    input.value = category_id;
                    modal.find('.modal-body').append(input);
                    modal.find('form').attr('action', '/orders?type=transport');
                    modal.find('.modal-title').text('Новый заказ в транспорте');
                }

            });



            function displayFieldErrors(response) {

                var gotErrors = false;
                $.each(response.responseJSON, function (key, item) {
                    $gotErrors = true;

                    $.each(item, function(key, value){
                        $.notify(value);
                    });
                });

                return gotErrors;
            }

            $(document).on('change', '#selectCatId', function(e){
                e.preventDefault();


                var category_id = $(this).val(),
                        csrf_token = $('input[name="_token"]').val();

                var selectBrand = this.parentElement.parentElement.children[1].querySelector('#selectMarkaId');
                var selectModel = this.parentElement.parentElement.children[2].querySelector('#selectModelId');

                $.ajax({
                    type: "GET",
                    url: '/ajax/list-auto-brands',
                    data: {category_id: category_id, _token: csrf_token},
                    success: function(data) {

                        selectBrand.options.length = 0;
                        selectBrand.options.add(new Option('Не выбрано', ''));

                        for (var i in data) {
                            selectBrand.options.add(new Option(data[i],i));
                        }

                        selectBrand.selectedIndex = 0;
                        selectBrand.setAttribute('data-category_id', category_id);

                        selectModel.options.length = 0;
                        selectModel.options.add(new Option('Не выбрано', ''));
                        selectModel.selectedIndex = 0;
                    },
                    error: function(jqXHR,code, exception) {
                        displayFieldErrors(jqXHR);
                    }
                });


            });


            $(document).on('change', '#selectMarkaId', function(e){
                e.preventDefault();

                var transport_brand_id = $(this).val(),
                    csrf_token = $('input[name="_token"]').val();

                $.ajax({
                    type: "GET",
                    url: '/ajax/list-auto-models',
                    data: {transport_brand_id: transport_brand_id, _token: csrf_token,  category_id: this.dataset.category_id},
                    success: function(data) {
                        var select = document.getElementById('selectModelId');
                        select.options.length = 0;

                        for (var i in data) {
                            select.options.add(new Option(data[i],i));
                        }
                    },
                    error: function(jqXHR,code, exception) {
                        displayFieldErrors(jqXHR);
                    }
                })
            });


            $( "#country" ).change(function () {


                if (country_id == '')
                {
                    var select = document.getElementById('city');
                    select.options.length = 0;
                    return  select.options.add(new Option('Город',null));
                }

                $('#city').parent().parent().removeClass('hidden');

                $.ajax({
                    type: "POST",
                    url: '/ajax/cities',
                    data: {id: country_id, _token: csrf_token},
                    success: function (data) {

                        var select = document.getElementById('city');
                        select.options.length = 0;

                        for (var i in data) {
                            select.options.add(new Option(data[i].name_ru,data[i].id));
                        }
                    }
                });

                $('#city').removeClass('hidden');
            });

        });


        $('#selectCatId').select2({
            placeholder: "Выберите категорию",
            allowClear: true
        } );
        $('#selectModelId').select2({
            placeholder: "Выберите модель",
            allowClear: true
        } );
        $('#selectMarkaId').select2({
            placeholder: "Выберите Марку",
            allowClear: true
        } );

        $('#startDatePicker').datepicker({
            format: "dd.mm.yyyy",
            language: "ru",
            autoclose:true,
            orientation:'top',
            //todayBtn:true,
            todayHighlight: true,
            toggleActive:true

        });

        $('.modal-trigger').leanModal({
            ready: function(){
//                if ($('#mapStartEndPoint').length) {
//                    GoogleMaps.create({
//                        name: 'startEndMap',
//                        element: document.getElementById('mapStartEndPoint'),
//                        options: {
//                            center: new google.maps.LatLng(51.1667, 71.4333),
//                            zoom: 8
//                        }
//                    });
//                }
            },
            complete:function(){
            }
        });


        $('.chooseFormOpen').click(function(e,t){
            e.preventDefault();
            $('#chooseForm').toggle();
        });

    </script>
@endsection