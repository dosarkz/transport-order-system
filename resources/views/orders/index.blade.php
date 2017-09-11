@extends('layouts.app')

@section('content')
        <div class="row">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h4 class="header center-align">Мои Заказы</h4>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 center-align">
                        <a href="#" class="waves-effect waves-light btn" data-toggle="modal" data-target="#new-order-modal">
                            <i class="mdi-content-add left"></i>
                            Добавить заказ
                        </a>
                    </div>
                </div>
                <br>

                <div class="row">

                    @foreach($orders as $order)
                            @include('orders.transport')
                    @endforeach
                </div>
            </section>

            @include('modals.new_order')
            @include('modals.base_modal')

        </div>
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
                var $form=  this.parentElement;
                $('#confirm').modal({ backdrop: 'static', keyboard: false })
                        .on('click', '#delete-btn', function(){
                            $form.submit();
                        });
            });

            $('#selectCatId').select2({
                placeholder: "Выберите категорию",
                allowClear: true
            });

            $('#select_city_id').select2({
                placeholder: "Выберите город",
                allowClear: true
            } );




        });



    </script>

@endsection