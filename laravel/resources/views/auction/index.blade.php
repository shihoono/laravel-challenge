@extends('layouts.app')

@section('content')

    <h2>ミニオークション!</h2>
    <h4>*出品されている商品</h4>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Finished</th>
                    <th>Endtime</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($biditems as $biditem)
                <tr>
                    <td>{{ $biditem->name }}</td>
                    @if($biditem->finished === 1)
                        <td>Finished</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $biditem->formatted_endtime }}</td>
                    <td>{!! link_to_route('auction.show', 'View', ['auction' => $biditem->id]) !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $biditems->links() }}
@endsection
