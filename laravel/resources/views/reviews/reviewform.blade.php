@extends('layouts.app')

@section('content')

    @if($bidinfo->biditem->user_id === $user->id || $bidinfo->user_id === $user->id)
        <h2>評価する</h2>

        <div class="row">
            <div class="col-6">
                {!! Form::model($review, ['route' => 'reviews.review']) !!}
            
                    <div class="form-group">
                        {!! Form::label('rate', 'Rate:') !!}
                        {!! Form::select('rate',['5' => '5(高)', '4' => '4', '3' => '3', '2' => '2', '1' => '1(低)'], null, ['class' => 'form-control', 'style' => 'margin-bottom:10px']) !!}
                        
                        {!! Form::label('comment', 'Comment') !!}
                        {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '3', 'style' => 'margin-bottom:10px']) !!}

                    </div>

                    {{ Form::hidden('id', $bidinfo->id) }}
                    {!! Form::submit('評価する', ['class' => 'btn btn-primary']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    @else
    <p>閲覧権限はありません</p>
    @endif
    
@endsection
