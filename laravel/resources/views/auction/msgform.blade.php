@extends('layouts.app')

@section('content')
    @if($bidinfo->user_id === $user->id || $bidinfo->biditem->user_id === $user->user_id)


        <h2>{{ $bidinfo->biditem->name }}の情報</h2>

        {!! Form::model($bidmessage, ['route' => 'auction.msg']) !!}

            <div class="form-group">
                {!! Form::label('price', 'message:') !!}
                {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => '3']) !!}
            </div>
            {{ Form::hidden('bidinfo_id', $bidinfo->id) }}
            {!! Form::submit('送信', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}

        <table class="table table-striped" style="margin-top:20px;">
            <thead>
                <tr>
                    <th>送信者</th>
                    <th>メッセージ</th>
                    <th>投稿日時</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->user->name }}</td>
                        <td>{{ $message->message }}</td>
                        <td>{{ $message->formatted_created_at}}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {{ $messages->links() }}
    @elseif($bidinfo->user_id !== $user->id || $bidinfo->biditem->user_id !== $user->user_id)
        <p>閲覧権限がありません</p>
    @endif
@endsection
