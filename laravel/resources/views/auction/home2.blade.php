@extends('layouts.app')

@section('content')

    <h2>{{ $user->name }}のホーム</h2>
    <h4>*出品情報</h4>

    <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Endtime</th>
                    <th>Messages</th>
                    <th>Transaction</th>
                    <th>Reviews</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($biditems as $biditem)
                <tr>
                    <td>{{ $biditem->id }}</td>
                    <td>{{ $biditem->name }}</td>
                    <td>{{ $biditem->formatted_endtime }}</td>
                    @if(isset($biditem->bidinfo))
                        <td>{!! link_to_route('auction.showmsgform', 'view', ['id' => $biditem->bidinfo->id]) !!}</td>
                        <td>{!! link_to_route('auction.showafterbidform', 'view', ['id' => $biditem->bidinfo->id]) !!}</td>
                        <td>{!! link_to_route('reviews.reviewform', 'view', ['id' => $biditem->bidinfo->id]) !!}</td>
                    @elseif(!isset($biditem->bidinfo))
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $biditems->links() }}

@endsection
