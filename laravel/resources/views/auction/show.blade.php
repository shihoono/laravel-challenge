@extends('layouts.app')

@section('content')

    <h2>{{ $biditem->name }}の情報</h2>
    <table class="table table-bordered" style="margin-bottom: 40px;">
        <tr>
            <th>出品者</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>商品名</th>
            <td>{{ $biditem->name}}</td>
        </tr>
        <tr>
            <th>商品説明</th>
            <td>{{ $biditem->description}}</td>
        </tr>
        <tr>
            <th>商品ID</th>
            <td>{{ $biditem->id}}</td>
        </tr>
        <tr>
            <th>終了時間</th>
            <td>{{ $biditem->formatted_endtime }}</td>
        </tr>
        <tr>
            <th>出品時間</th>
            <td>{{ $biditem->formatted_created_at }}</td>
        </tr>
        <tr>
            <th>終了した？</th>
            @if($biditem->finished === 1)
            <td>YES</td>
            @elseif($biditem->finished === 0)
            <td>NO</td>
            @endif
        </tr>
    </table>

    <h4>落札情報</h4>
    @if($bidinfo->isNotEmpty())
        @foreach ($bidinfo as $bidinfo)
            <table class="table table-striped" style="margin-bottom:40px;">
                <thead>
                    <tr>
                        <th>落札者</th>
                        <th>落札金額</th>
                        <th>落札日時</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $bidinfo->user->name }}</td>
                        <td>{{ $bidinfo->price }}円</td>
                        <td>{{ $bidinfo->formatted_created_at }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @elseif($bidinfo->isEmpty())
    <p>落札はありません。</p>
    @endif

    <h4>入札情報</h4>

    @if($biditem->finished === 0)
        {!! link_to_route('auction.bidform', '<入札する>', ['id' => $biditem->id]) !!}
    @endif

    <table class="table table-striped" style="margin-top:10px;">
        <thead>
            <tr>
                <th>入札者</th>
                <th>金額</th>
                <th>入札日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bidrequests as $bidrequest)
                <tr>
                    <td>{{ $bidrequest->user->name }}</td>
                    <td>{{ $bidrequest->price }}円</td>
                    <td>{{ $bidrequest->formatted_created_at}}</td>
                </tr>
                @endforeach
            </tbody>
    </table>

@endsection
