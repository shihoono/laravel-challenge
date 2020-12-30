@extends('layouts.app')

@section('content')

    <h2>{{ $biditem->name }}の情報</h2>

    <table class="table table-bordered">
        <tr>
            <th>出品者</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>商品名</th>
            <td>{{ $biditem->name}}</td>
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
            <td></td>
        </tr>
    </table>

@endsection
