@extends('layouts.app')

@section('content')

    <h2>入札する</h2>

    <div class="row">
        <div class="col-6">
            {!! Form::model($bidrequest, ['route' => 'auction.bid']) !!}

                <div class="form-group">
                    {!! Form::label('price', 'price:') !!}
                    {!! Form::input('number', 'price', null, ['class' => 'form-control']) !!}
                </div>
                {{ Form::hidden('biditem_id', $biditem->id) }}
                {!! Form::submit('入札', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>

@endsection
