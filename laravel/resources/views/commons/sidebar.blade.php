<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    {!! link_to_route('auction.home', 'あなたの落札情報', [], ['class' => 'nav-link', 'id' => 'v-pills-home-tab', 'role' => 'tab', 'aria-controls' => 'v-pills-home']) !!}
    {!! link_to_route('auction.home2', 'あなたの出品情報', [], ['class' => 'nav-link', 'id' => 'v-pills-home2-tab', 'role' => 'tab', 'aria-controls' => 'v-pills-home2']) !!}
    {!! link_to_route('auction.create', '商品を出品する', [], ['class' => 'nav-link', 'id' => 'v-pills-create-tab', 'role' => 'tab', 'aria-controls' => 'v-pills-create']) !!}
    {!! link_to_route('auction.index', '商品リストを見る', [], ['class' => 'nav-link', 'id' => 'v-pills-index-tab', 'role' => 'tab', 'aria-controls' => 'v-pills-index']) !!}
</div>
