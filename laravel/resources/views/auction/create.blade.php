@extends('layouts.app')

@section('content')

    <h2>商品を出品する</h2>

    <div class="row">
        <div class="col-6">
            {!! Form::model($biditem, ['route' => 'auction.store']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}

                    {!! Form::label('description', 'Description:') !!}
                    {!! Form::text('description', null, ['class' => 'form-control']) !!}

                    {!! Form::label('endtime', 'Endtime:') !!}
                    {!! Form::datetimeLocal('endtime', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('投稿', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
