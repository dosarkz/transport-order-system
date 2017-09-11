@extends('layouts.app')

@section('content')
        <div class="row">

            <section class="content-header">
                <h1>
                    Мои проекты - <a href="/projects/{{$project->id}}">{{$project->name}}</a>
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
                                <h3 class="box-title">Редактировать заказ</h3>
                            </div>
                            <!-- /.box-header -->

                            @include('projects.orders.form')

                        </div>
                    </div>
                </div>

                <br>
                <br>
            </section>

        </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/datetimepicker/bootstrap-datetimepicker.min.css">
@endsection


@section('js-append')
    <script src="/datetimepicker/moment.js"></script>
    <script src="/datetimepicker/moment-ru.js"></script>
    <script src="/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(document).ready(function() {

            var sectionsCount = 0;

            $(document).on('click', '#add-auto', function(e){
                e.preventDefault();
                sectionsCount++;

                var drivers = $('#notificationDrivers').select2("data"),
                        driversList = '';
                var category = $('#selectCatId option:selected');
                var brand = $('#selectMarkaId option:selected');
                var model = $('#selectModelId option:selected');

                drivers.forEach(function(item, i, arr){
                    driversList += '<li>Поставщик:  '+item.text+'</li>' +
                            '<input type="hidden" value="'+item.id+'" name="drivers[]">';
                });

                if(drivers == '')
                {
                    return new Noty({
                        type: 'error',
                        text: 'Выберите поставщика',
                    }).show();
                }


                var html = '<div class="form-group well white"> ' +

                        '<p>Поставщики:</p>'+
                        '<ul>' +
                        driversList +
                        '</ul>' +
                        '<p><a class="btn btn-warning" id="remove-clone-btn">Удалить</a></p>'    +
                        '</div>';


                $('#list_drivers').html(html);


            });

            $(document).on('click', '#remove-clone-btn', function() {
                this.parentElement.parentElement.remove();
            });


            $("#date_start_picker").datetimepicker({
                locale: 'ru'
            });

            $("#date_end_picker").datetimepicker({
                locale: 'ru'
            });

            $("#groupOrderServiceId").select2({
                placeholder: "Выберите услугу",
                allowClear: true
            });

            $("#groupOrderCityId").select2({
                placeholder: "Выберите город",
                allowClear: true
            });

            $("#groupContragentId").select2({
                placeholder: "Выберите заказчика",
                allowClear: true
            });


            $("#notificationDrivers").select2({
                ajax: {
                    url: "/ajax/list-all-drivers",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            brand_id: $("#notificationDrivers").attr("data-brand_id"),
                            category_id: $("#notificationDrivers").attr("data-category_id"),
                            model_id: $("#notificationDrivers").attr("data-model_id")
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.current_page || 1;

                        return {
                            results: data.data,
                            pagination: {
                                more: (params.current_page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },

                placeholder: "Выберите поставщиков",
                allowClear: true,
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            });


//             $('#selectCatId').select2({
//                placeholder: "Выберите категорию",
//                allowClear: true
//            } );
//
//            $('#selectModelId').select2({
//                placeholder: "Выберите модель",
//                allowClear: true
//            } );
//            $('#selectMarkaId').select2({
//                placeholder: "Выберите Марку",
//                allowClear: true
//            } );

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


            $(document).on('change', '#selectMarkaId', function(e){
                e.preventDefault();

                var selectModel = this.parentElement.parentElement.children[2].querySelector('#selectModelId');
                var transport_brand_id = $(this).val(),
                        csrf_token = $('input[name="_token"]').val();
                var selectNotificationDrivers = document.getElementById('notificationDrivers');

                $.ajax({
                    type: "GET",
                    url: '/ajax/list-auto-models',
                    data: {transport_brand_id: transport_brand_id, _token: csrf_token,
                        category_id: this.dataset.category_id},
                    success: function(data) {
                        selectModel.options.length = 0;
                        selectModel.options.add(new Option('Не выбрано', ''));
                        for (var i in data) {
                            selectModel.options.add(new Option(data[i],i));
                        }
                    },
                    error: function(jqXHR,code, exception) {
                        displayFieldErrors(jqXHR);
                    }
                });

                selectNotificationDrivers.setAttribute('data-brand_id', transport_brand_id);
                selectNotificationDrivers.setAttribute('data-category_id', this.dataset.category_id);
                selectNotificationDrivers.removeAttribute('data-model_id');
            });

            $(document).on('change', '#selectModelId', function(e){
                e.preventDefault();
                document.getElementById('notificationDrivers').setAttribute('data-model_id', $(this).val());
            });

            $(document).on('click','.groupOrderContactAddBtn', function(e){
                e.preventDefault();
                var clone = $('#groupOrderContactContainer').clone();
                clone.find(".groupOrderContactDeleteBtn").removeClass('hidden');
                clone.find(".groupOrderContactAddBtn").addClass('hidden');

                clone.appendTo('#contacts-cloned');
            });

            $(document).on('click', '.groupOrderContactDeleteBtn', function() {
                this.parentElement.parentElement.remove();
            });




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
        });


    </script>
@endsection