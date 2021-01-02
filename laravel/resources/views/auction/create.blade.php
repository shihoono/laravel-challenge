@extends('layouts.app')

@section('content')

    <h2>商品を出品する</h2>

    <div class="row">
        <div class="col-6">
            {!! Form::model($biditem, ['route' => 'auction.store']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'style' => 'margin-bottom:10px']) !!}

                    {!! Form::label('description', 'Description:') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3', 'style' => 'margin-bottom:10px']) !!}

                    {!! Form::label('endtime', 'Endtime:') !!}
                    {!! Form::datetimeLocal('endtime', null, ['class' => 'form-control', 'style' => 'margin-bottom:10px']) !!}
                </div>

                {!! Form::submit('投稿', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
