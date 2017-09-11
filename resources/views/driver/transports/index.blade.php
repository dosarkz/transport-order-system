@extends('layouts.app')

@section('content')
        <div class="row">
            <section class="content-header">
                <h1>Мои Авто</h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-6">
                        <a class="btn btn-flat btn-success"  href="/driver/transports/choose-category">
                            Добавить авто
                        </a>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Существующие авто</h3>
                            </div>
                            <div class="box-body table-responsive">

                                <div class="row">
                                    <div class="col-md-11">

                                        <table class="table">
                                            <thead class="thead-inverse">
                                            <tr>
                                                <th>Фото авто</th>
                                                <th>Гос номер</th>
                                                <th>Вид авто</th>
                                                <th>Марка авто</th>
                                                <th>Водитель</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($transports as $item)

                                                <tr>
                                                    <td>
                                                        @if($item->transportImages)
                                                            @if($img = $item->transportImages()->where('is_main', true)->first())
                                                                @if($img->image)
                                                                    <img src="/{{$img->image->getThumb()}}" alt="">
                                                                @endif
                                                            @else
                                                                @if($item->transportImages->first())
                                                                    <img src="/{{$item->transportImages->first()->image->getThumb()}}" alt="">
                                                                @endif
                                                            @endif
                                                        @else
                                                            <img src="/img/icon_160.png">
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->car_gos_number }}</td>
                                                    <td>{{ $item->transportCategory->name }}</td>
                                                    <td> {{$item->transportBrand ? $item->transportBrand->name : null}}</td>
                                                    <td> {{$item->driver->fullName}}</td>
                                                    <td>
                                                        <a  class="btn btn-xs btn-primary" href="/driver/transports/{{ $item->id }}/edit">редактировать</a>

                                                        {{ Form::open(array('url' => '/driver/transports/' . $item->id, 'class' => 'form-delete pull-right')) }}
                                                        {{ Form::hidden('_method', 'DELETE') }}
                                                        {{ Form::submit('удалить', array('class' => 'btn btn-xs btn-warning destroy-item')) }}
                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    @include('modals.base_modal')

@endsection

@section('js-append')
    <script>
        $(document).ready(function() {

            $('.destroy-item').on('click', function(e){
                e.preventDefault();
                var $form =  this.parentElement;

                $('#confirm').modal({ backdrop: 'static', keyboard: false })
                        .on('click', '#delete-btn', function(){
                            $form.submit();
                        });
            });


        });



    </script>

@endsection