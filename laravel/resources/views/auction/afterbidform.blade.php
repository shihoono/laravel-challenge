@extends('layouts.app')

@section('content')

    <h2>{{ $bidinfo->biditem->name }}の取引</h2>

    @if($bidinfo->user_id === $user->id && empty($bidinfo->bidder_name))
        <h4>＊発送先情報</h4>
        <p>発送先を入力してください</p>

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
                        {!! Form::submit('送信', ['class' => 'btn btn-primary', 'name' => 'bidder_info']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    @elseif($bidinfo->user_id === $user->id && !empty($bidinfo->bidder_name) && $bidinfo->trading_status === 0)
        <p>出品者の商品発送をお待ち下さい</p>
    @elseif($biditem->user_id === $user->id)
        @if($bidinfo->trading_status === 0 && empty($bidinfo->bidder_name))
            <p>落札者の発送先連絡をお待ち下さい</p>
        @endif
    @endif

    @if($bidinfo->trading_status === 0 && !empty($bidinfo->bidder_name))
        <table class="table table-bordered" style="margin-bottom: 40px;">
            <tr>
                <th>宛先氏名</th>
                <td>{{ $bidinfo->bidder_name }}</td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>{{ $bidinfo->bidder_address }}</td>
            </tr>
            <tr>
                <th>商品説明</th>
                <td>{{ $bidinfo->bidder_phone_number}}</td>
            </tr>
        </table>
        @if($biditem->user_id === $user->id)
            {!! Form::model($bidinfo, ['route' => 'auction.afterbid']) !!}
                {{ Form::hidden('id', $bidinfo->id) }}
                {!! Form::submit('発送完了', ['class' => 'btn btn-primary btn-lg', 'name' => 'sent']) !!}
            {!! Form::close() !!}
        @endif
    @endif

    @if($bidinfo->trading_status === 1 && $biditem->user_id === $user->id)
        <p>発送連絡が完了しました</p>
        <p>落札者からの受取連絡をお待ち下さい</p>
    @elseif($bidinfo->trading_status === 1 && $bidinfo->user_id === $user->id)
        {!! Form::model($bidinfo, ['route' => 'auction.afterbid']) !!}
            {{ Form::hidden('id', $bidinfo->id) }}
            {!! Form::submit('受取完了', ['class' => 'btn btn-primary btn-lg', 'name' => 'received']) !!}
        {!! Form::close() !!}
    @endif

    @if($bidinfo->trading_status === 2 && $biditem->user_id === $user->id)
        <p>落札者の受取が完了しました</p>
        <p>取引完了</p>
    @elseif($bidinfo->trading_status === 2 && $bidinfo->user_id === $user->id)
        <p>受取連絡が完了しました</p>
        <p>取引完了</p>
    @endif
@endsection
