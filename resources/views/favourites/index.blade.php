@extends('layouts.app')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Мои Избранные</h3>
        </div>

            <div class="row">
                <div class="col-md-12">
                    @foreach($models as $item)
                        @include('transports._partial_list_transport')
                    @endforeach
                </div>
            </div>
    </div>
@endsection