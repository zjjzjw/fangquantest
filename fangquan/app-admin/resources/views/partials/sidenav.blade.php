<ul class="nav nav-pills nav-stacked">

    @foreach($menus ?? [] as $menu)
        @if($menu['visible'])
            <li role="presentation">
                <a href="#"><span class="caret"></span>{{$menu['title']}}</a>
                <ul class="nav sidebar-trans">
                    @foreach($menu['sub_items'] as $menu_item)
                        @if($menu_item['visible'])
                            <li @if($menu_item['selected']) class="active" @endif>
                                <a href="{{$menu_item['route']}}">
                                    <i class="iconfont">{{$menu_item['icon']}}</i>{{$menu_item['title']}}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach

</ul>
