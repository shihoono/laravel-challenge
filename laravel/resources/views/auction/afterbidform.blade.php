@extends('layouts.app')

@section('content')

    <h2>{{ $bidinfo->biditem->name }}の取引</h2>

    <h4>＊発送先情報</h4>
    <p>発送先を入力してください</p>
    @if($bidinfo->user_id === $user->id)

        <div class="row">
            <div class="col-6">
                {!! Form::model($bidinfo, ['route' => 'auction.afterbid']) !!}
            
                    <div class="form-group">
                        {!! Form::label('bidder_name', '宛先氏名:') !!}
                        {!! Form::text('bidder_name', null, ['class' => 'form-control', 'style' => 'margin-bottom:10px']) !!}

                        {!! Form::label('bidder_address', '住所:') !!}
                        {!! Form::textarea('bidder_address', null, ['class' => 'form-control', 'rows' => '3', 'style' => 'margin-bottom:10px']) !!}

                        {!! Form::label('bidder_phone_number', '電話番号:') !!}
                        {!! Form::text('bidder_phone_number', null, ['class' => 'form-control']) !!}

                    </div>

                        {{ Form::hidden('id', $bidinfo->id) }}
                        {!! Form::submit('送信', ['class' => 'btn btn-primary']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    @elseif($biditem->user_id === $user->id)
        <p>落札者の発送先連絡をお待ち下さい</p>
    @endif

@endsection
