@extends('layouts.app')

@section('content')

    <h2>{{ $user->name }}のホーム</h2>
    <h4>*落札情報</h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created</th>
                <th>Messages</th>
                <th>Transaction</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bidinfo as $bidinformation)
            <tr>
                <td>{{ $bidinformation->id }}</td>
                <td>{{ $bidinformation->biditem->name }}</td>
                <td>{{ $bidinformation->formatted_created_at }}</td>
                <td>{!! link_to_route('auction.msgform', 'view', ['id' => $bidinformation->id]) !!}</td>
                <td>{!! link_to_route('auction.afterbidform', 'view', ['id' => $bidinformation->id]) !!}</td>
                <td>{!! link_to_route('reviews.reviewform', 'view', ['id' => $bidinformation->id]) !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
        {{ $bidinfo->links() }}
@endsection
