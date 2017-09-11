<div class="row">
    {{ Form::open(array('url' => secure_url_env("/projects/$project->id/accounts"),
    'method'=> 'POST', 'name'=>'createOperator', 'class' => 'form-horizontal'))}}

    <div class="col s12 form-group">
        <label for="user" class="active">Пользователь</label>
        {{Form::select('user_id',\App\Models\User::all()->pluck('fullNameWithPhone','id'), '', [
        'class' => 'form-control', 'placeholder' => 'Выберите пользователя',
        'id' => 'user'])}}
    </div>

    <div class="col s12 form-group">
        <label for="post">Должность</label>

        {{Form::select('post_id',[
            1 => 'Менеджер',
            2 => 'Диспетчер',
            3 => 'Механик',
            4 => 'Офис менеджер',
            5 => 'Бухгалтер',
            6 => 'Юрист',
            7 => 'Программист'
        ], '', ['class' => 'form-control', 'placeholder' => 'Выберите должность',
        'id' => 'post'])}}

    </div>

    <div class="col s12 form-group">
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>

    {{Form::close()}}
</div>