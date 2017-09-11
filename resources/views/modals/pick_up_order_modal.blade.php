<div class="modal fade" id="pick_up_order_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Забрать заказ</h4>
                </div>
                <form method="POST" action="/driver/orders/pick-up-the-order">
                    {{csrf_field()}}

                <div class="modal-body">
                    {{Form::hidden('order_id', '', ['id' => 'pick_up_order_id'])}}
                   <div class="row">
                       <div class="form-group">
                           <label for="car_id">Выберите ваш авто</label>
                           {{Form::select('car_id', auth()->user()->transports->pluck('car_gos_number', 'id'), '', ['id' => 'car_id',
                           'placeholder' => 'Выберите авто', 'class' => 'form-control', 'style' => 'width:100%;'
                           ])}}
                       </div>
                   </div>


                    <div class="row">
                        <div class="form-group">
                            <label for="car_id">Ваша цена</label>
                            {{Form::text('driver_price', '', [
                            'placeholder' => 'Ваша цена', 'class' => 'form-control', 'style' => 'width:100%;'
                            ])}}
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="pick_up_order_btn">Отправить</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Отмена</button>
                </div>
                </form>
            </div>
    </div>
</div>