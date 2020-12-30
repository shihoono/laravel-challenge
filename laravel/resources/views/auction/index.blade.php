@extends('layouts.app')

@section('content')

    <h2>ミニオークション!</h2>
    <h3>*出品されている商品</h3>

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
                    <td></td>
                    <td>{{ $biditem->endtime->format('Y/n/d g:i A') }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

@endsection