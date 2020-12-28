<div class="page-header">
    <h2>Users</h2>
</div>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>name</th>
            <th>email</th>
            <th>opration</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    {!! link_to_route('admin.edit', '編集', ['admin' => $user->id], ['class' => 'btn btn-primary btn-sm']) !!}
                    <a href="" class="btn btn-danger btn-sm">削除</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        {{ $users->links() }}
    </table>