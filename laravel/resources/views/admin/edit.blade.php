@extends('auth.app')

@section('content')

    <div class="text-center">
        <h2>{{ $user->name }}の編集ページ</h2>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::model($user, ['route' => ['admin.update', $user->id], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('role', 'Role') !!}
                    {!! Form::select('role', ['admin' => 'admin', 'user' => 'user'], 'user', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirmation') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('更新', ['class' => 'btn btn-primary btn-block', 'style' => 'margin-bottom: 20px']) !!}

                {!! Form::model($user, ['route' => ['admin.destroy', $user->id], 'method' => 'delete']) !!}
                    {!! Form::submit('削除', ['class' => 'btn btn-danger btn-block']) !!}
                {!! Form::close() !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
