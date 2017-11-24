<div class="press-box">
    <ul>
        @for($p_index = 10; $p_index <= 100; $p_index = $p_index + 10)
            @if($p_index <= $brand_progress['score'])
                <li class="active-dian">
                    <i></i>
                    <span>{{$p_index}}%</span>
                </li>
            @else
                <li class="dian">
                    <i></i>
                </li>
            @endif

            @if($p_index != 100)
                @if($p_index < $brand_progress['score'])
                    <li class="active-line"></li>
                @else
                    <li class="line"></li>
                @endif
            @endif
        @endfor
    </ul>
</div>
