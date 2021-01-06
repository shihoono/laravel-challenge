@extends('layouts.app')

@section('content')

    <h2>{{ $user->name }}の評価情報</h2>
    <table class="table table-bordered col-sm-4" style="margin-bottom: 40px;">
        <tr>
            <th>評価平均</th>
            <td>{{ round($rateAvg, 1) }}</td>
        </tr>
    </table>

    <table class="table table-striped" style="margin-bottom:40px;">
        <thead>
            <tr>
                <th>評価コメント</th>
                <th>評価日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->formatted_created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
