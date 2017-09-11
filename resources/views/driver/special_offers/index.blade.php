@extends('layouts.app')

@section('content')
        <div class="row">

            <section class='content-header center-align'>
                <a class="waves-effect waves-light btn" id="createSOBtn">
                    <i class="material-icons left">add</i>
                    {{--Закрыть форму спец. предложений--}}
                    Создать специальное предложение
                </a>
            </section>
            <section class='content'>


                @foreach($special_offers as $special_offer)
                <div class="row card green lighten-5">
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">заказ #{{$special_offer->id}}<i class="material-icons right">more_vert</i></span>
                        <div class="row">
                            <img/>
                            <div class="order-right-part col s8">
                                <div class="col s12 order-name-status">
                                    {{$special_offer->user->fullName()}} {{$special_offer->user->company}}
                                </div>
                                <div class="col s12 top-buffer">
                                    <b>Описание предложения: </b> {{$special_offer->order->description}}<br>
                                    <b>Откуда: </b> {{$special_offer->startPoint}}<br>
                                    <b>Куда: </b> {{$special_offer->endPoint}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </section>

        </div>

@endsection
