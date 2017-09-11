<div class="modal fade" id="comment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <form action="" method="POST" id="comment-form">
        {{csrf_field()}}

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Оставить комментарии</h4>
            </div>
            <div class="modal-body">
               {{Form::textarea('description', '', ['class' => 'form-control', 'required' => 'required'])}}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary" id="send-btn">Отправить</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
    </form>
</div>