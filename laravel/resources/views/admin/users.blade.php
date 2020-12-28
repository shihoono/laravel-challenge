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
                    <a href="" class="btn btn-primary btn-sm">詳細</a>
                    <a href="" class="btn btn-primary btn-sm">編集</a>
                    <a href="" class="btn btn-danger btn-sm">削除</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        {{ $users->links() }}
    </table>