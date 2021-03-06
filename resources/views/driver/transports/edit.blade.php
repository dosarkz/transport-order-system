@extends('layouts.app')

@section('content')
        <div class="row">
            @include('driver.transports.form')
        </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
    {{--<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">--}}
@endsection


@section('js-append')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.2/js/materialize.min.js"></script>
    <script src="/plugins/multiFile/multiFile.min.js"></script>
    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/plugins/datepicker/locales/bootstrap-datepicker.ru.js"></script>
    <script>
        $(document).ready(function(){
            $('ul.tabs').tabs();

            $("#car_brand_id").change(function(e){
                e.preventDefault();

                var transport_brand_id = $(this).val(),
                        csrf_token = $('input[name="_token"]').val();

                $.ajax({
                    type: "GET",
                    url: '/ajax/list-auto-models',
                    data: {transport_brand_id: transport_brand_id, _token: csrf_token},
                    success: function(data) {
                        var select = document.getElementById('car_model_type_id');
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

        });

        $(document).on('focus', '.editTransportDocDate', function() {
            $(this).datepicker(
                    {
                        format: "dd.mm.yyyy",
                        language: "ru",
                        autoclose: true,
                        constrainInput: false,
                        orientation: 'top',
                        //todayBtn:true,
                        todayHighlight: true,
                        toggleActive: true
                    }
            );
        });


        $(document).on('click', '.editTransportDocTypeUploadBtn', function() {
            this.parentNode.childNodes[11].click(function(e){
                e.preventDefault();
            });
        });

        $(document).on('change', '#editTransportDocTypeUpload', function(e) {
            e.preventDefault();
            var element = this.parentNode.childNodes[15].childNodes[1];
            console.log(element);
            element.innerHTML = 'Выбранный файл: ' + this.files[0].name;
        });

        var sectionsCount = 1;

        $("#add-more-document").click(function(e){
            e.preventDefault();
            sectionsCount++;

            var clone = $('#document_block').clone();

            clone.find("#remove_clone").css('display', 'block');
            clone.find("select#document_type").attr('name', 'documents['+sectionsCount+'][document_type]');
            clone.find(".editTransportDocDate").attr('name', 'documents['+sectionsCount+'][document_expired_at]');
            clone.find("#editTransportDocTypeUpload").attr('name', 'documents['+sectionsCount+'][document_file]');
            clone.find(".editTransportDocDate").val('');
            clone.find("#selected_file").html('');

            clone.appendTo('#document_block_cloned');
        });

        $(document).on('click', '#remove_clone_btn', function() {
            this.parentElement.parentElement.parentElement.remove();
        });

        $(".document-delete-btn").click(function()
        {
            var document_id = this.dataset.fileid,
                    csrf_token = $('input[name="_token"]').val();

            $.ajax({
                type: "DELETE",
                url: '/ajax/destroy-document/'+document_id,
                data: { _token: csrf_token},
                success: function(data) {
                    if(data.status  == 'deleted')
                    {
                        window.location.reload();
                    }
                },
                error: function(jqXHR,code, exception) {
                }
            })
        });

        $('#confirm').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-footer button#delete-btn').attr('data-id', id)
        });

        $("#delete-btn").click(function()
        {
            var transport_image_id = this.dataset.id,
                    csrf_token = $('input[name="_token"]').val();

            console.log(transport_image_id);

            $.ajax({
                type: "DELETE",
                url: '/ajax/destroy-transport-image/'+transport_image_id,
                data: { _token: csrf_token},
                success: function(data) {
                    if(data.status  == 'deleted')
                    {
                        window.location.reload();
                    }
                },
                error: function(jqXHR,code, exception) {
                }
            })
        });



        $('#transport_images').click();

        $('#car_color').select2({
            placeholder: "Выберите цвет",
            allowClear: true
        });
        $('#car_class_id').select2({
            placeholder: "Выберите класс",
            allowClear: true
        });
    </script>
@endsection