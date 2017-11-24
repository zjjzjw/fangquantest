<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/result')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/result')); ?>

@extends('layouts.master')
@section('content')
    <div class="wrapper-box">
        <div class="content-box">
            @include('partials.exhibition-h5.header')
            <div class="result-content">
                <img src="/www/image/exhibition/result/result.jpeg" alt="">
                <ul class="result">
                    @foreach(($items ?? [] ) as $item)
                        <li>
                            <a href="{{route('exhibition.result-detail', ['id' => $item['id']])}}">
                                <p>{{$item['title'] or ''}}</p>
                                <p>{{$item['publish_at'] or ''}}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <a href="JavaScript:void(0);" class="show-more">更多</a>
            </div>
            @include('partials.exhibition-h5.footer')
        </div>
    </div>

    @include('common.loading-pop')
    <script type="text/html" id="show_moreTpl">
        <% for ( var k = 0; k < data.items.length; k++ ) { %>
           <li class="no-img">
               <a href="/exhibition/result-detail/<%=data.items[k].id%>">
                   <div class="active-title">
                      <p><%=data.items[k].title%></p>
                      <p><%=data.items[k].publish_at%></p>
                   </div>
               </a>
          </li>
        <% } %>
    </script>
@endsection