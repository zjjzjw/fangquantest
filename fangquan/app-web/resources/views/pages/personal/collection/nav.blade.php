<?php

$url_name = request()->route()->getName();
?>

<ul class="collection_tab">
    <li @if($url_name == 'personal.collection.collection-project') class="active" @endif>
        <a href="{{route('personal.collection.collection-project')}}">
            项目（ {{$count['project_favorite_count'] or 0}} ）
        </a>
    </li>
    <li @if($url_name == 'personal.collection.collection-provider') class="active" @endif>
        <a href="{{route('personal.collection.collection-provider')}}">
            供应商（ {{$count['provider_favorite_count'] or 0}} ）
        </a>
    </li>
    <li  @if($url_name == 'personal.collection.collection-product') class="active" @endif>
        <a href="{{route('personal.collection.collection-product')}}">
            产品（ {{$count['product_favorite_count'] or 0}} ）
        </a>
    </li>
    <li @if($url_name == 'personal.collection.collection-scheme') class="active" @endif>
        <a href="{{route('personal.collection.collection-scheme')}}">
            方案（ {{$count['programme_favorite_count'] or 0}} ）
        </a>
    </li>
</ul>
