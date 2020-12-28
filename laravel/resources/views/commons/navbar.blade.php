<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">Auction</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">{!! link_to_route('register.get', 'Register', [], ['class' => 'nav-link']) !!}</li>
                        <li class="nav-item">{!! link_to_route('admin.index', 'Users', [], ['class' => 'nav-link']) !!}</li>
                    @endif
                    <li class="nav-item">{!! link_to_route('logout.get', 'Logout', [], ['class' => 'nav-link']) !!}</li>
                @endif
            </ul>
        </div>
    </nav>
</header>
