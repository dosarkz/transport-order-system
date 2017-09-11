@section('css')
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
@endsection

    <div class="row">
        <div class="col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($model->exists)
                {{ Form::open(array('url' => sprintf('%s/%s',$url, $model->id),'method'=> 'PUT', 'name'=>'update-contest', 'files' => false))}}
            @else
                {{ Form::open(array('url' => secure_url_env($url),'method'=> 'POST', 'name'=>'create-contest', 'files' => false))}}
            @endif

            <div class="box-body">


                <div class="row">
                    <div class="input-field col s4">
                        {{Form::select('company_type', \App\Models\CompanyType::pluck('name','id'), $model->company_type,
                        ['class' => 'browser-default'])}}
                    </div>

                    <div class="input-field col s8">
                        {{Form::text('company_name_full', $model->company_name_full, ['id' => 'projectCompanyField',
                        'placeholder' => 'Без указаний префиксов ТОО,ИП и т.д.'])}}
                        <label for="projectCompanyField" class="active">Наименование контрагента</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::text('director_name', $model->director_name, ['id' => 'projectDirectorField'])}}
                        <label for="projectDirectorField" class="active">ФИО директора</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::text('f_director_name', $model->f_director_name, ['id' => 'projectFDirectorField'])}}
                        <label for="projectFDirectorField" class="active">ФИО бухгалтера</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::text('fact_address', $model->fact_address, ['id' => 'projectFactAddressField'])}}
                        <label for="projectFactAddressField" class="active">Адрес, фактический</label>
                    </div>

                    <div class="input-field col s6">
                        {{Form::text('legal_address', $model->legal_address, ['id' => 'projectLegalAddressField'])}}
                        <label for="projectLegalAddressField" class="active">Адрес, юридический</label>
                    </div>

                    <div class="input-field col s6">
                        {{Form::number('phone', $model->phone, ['id' => 'projectPhoneField'])}}
                        <label for="projectPhoneField" class="active">Телефон</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::text('email', $model->email, ['id' => 'projectEmailField','type' => 'email'])}}
                        <label for="projectEmailField" class="active">Email</label>
                    </div>

                    <div class="input-field col s12">
                        {{Form::textarea('description', $model->description, ['id' => 'projectDescriptionField', 'class' =>
                        'materialize-textarea'])}}
                        <label for="projectDescriptionField">Описание</label>
                    </div>

                    <div class="input-field col s6">
                        {{Form::text('bin', $model->bin, ['id' => 'projectBinField'])}}
                        <label for="projectBinField" class="active">БИН/ИИН</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::text('bank_name', $model->bank_name, ['id' => 'projectBankField'])}}
                        <label for="projectBankField" class="active">Наименование банка</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::text('bank_account', $model->bank_account, ['id' => 'projectBankAccountField'])}}
                        <label for="projectBankAccountField" class="active">Расчетный счет</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::text('bank_bik', $model->bank_bik, ['id' => 'projectBankBikField'])}}
                        <label for="projectBankBikField" class="active">БИК</label>
                    </div>
                    <div class="input-field col s6">
                        {{Form::checkbox('nds_value', $model->nds_value, $model->nds_value, ['id' => 'projectNDSField'])}}
                        <label for="projectNDSField">Плательщик НДС</label>
                    </div>
                    <div class="input-field col s6">

                        {{Form::checkbox('is_nds', $model->is_nds,$model->is_nds, ['id' => 'projectIsProvider'])}}
                        <label for="projectIsProvider">Поставщик услуг</label>
                    </div>

                </div>

                {{Form::hidden('project_id', $project->id)}}


                <br>
                {{ Form::submit($model->exists ?  'Обновить' : 'Сохранить',['class' => 'btn btn-success']) }}
                {{ Form::close() }}
            </div>
        </div>
</div>


@section('js-append')
    <script src="/js/admin/functions.js"></script>
    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/plugins/datepicker/locales/bootstrap-datepicker.ru.js"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker-input').datepicker({
                isRTL: false,
                'format': 'yyyy-mm-dd',
                language: 'ru'
            });
        });
    </script>
@endsection