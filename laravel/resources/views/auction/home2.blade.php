@extends('layouts.app')

@section('content')

    <h2>{{ $user->name }}のホーム</h2>
    <h4>出品情報</h4>

    <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Endtime</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($biditems as $biditem)
                <tr>
                    <td>{{ $biditem->id }}</td>
                    <td>{{ $biditem->name }}</td>
                    <td>{{ $biditem->formatted_endtime }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $biditems->links() }}

@endsection
