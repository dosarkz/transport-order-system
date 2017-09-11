<div class="modal fade" id="new-order-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Новый заказ</h4>
            </div>
            <form action="/orders?type=transport" method="POST">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col m12">
                            {{Form::hidden('status_id', \App\Models\Order::STATUS_IN_PROCESSING)}}

                            <div class="col m12 form-group" id="category_id">
                                <label for="selectCatId">Вид авто</label>
                                {{Form::select('category_id', \App\Models\TransportCategory::orderBy('name','asc')->pluck('name','id'),'', ['class' =>
                                                    'form-control select2 select2-hidden-accessible', 'id'=> 'selectCatId', 'style'=> 'width: 100%',
                                                    'placeholder' => 'Не важно'])}}
                            </div>

                            <div class="col m12 form-group" id="city_block">
                                <label for="selectCatId">Город</label>
                                {{Form::select('city_id', \App\Models\City::pluck('name_ru','id'), auth()->user()->city_id, ['class' =>
                                                    'form-control select2', 'id'=> 'select_city_id', 'style'=> 'width: 100%',
                                                    'placeholder' => 'Выберите город'])}}
                            </div>

                            <div class="col s6">
                                <label for="orderStartPoint">Откуда</label>
                                <input type="text" name="start_point_text" placeholder="откуда" id="orderStartPoint" data-lat="" data-lng="">
                            </div>

                            <div class="col s6">
                                <label for="orderEndPoint">Куда</label>
                                <input type="text" placeholder="куда" name="end_point_text" id="orderEndPoint" data-lat="" data-lng="">
                            </div>

                            <div class="input-field col s6">
                                <label for="orderPrice">Цена</label>
                                <input placeholder="стоимость поездки" name="client_price" id="orderPrice" type="text" class="validate">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary js-modalMyOrdersCreateBtn">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>