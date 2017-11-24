<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/gather/agenda')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/gather/agenda')); ?>
<?php
App\Wap\Http\Controllers\Resource::addParam([
    'type' => $type ?? 0
])
?>
@extends('layouts.master')
@section('content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="bg-image"></div>
            <aside>
                <ul>
                    <li><span>13:30-14:00</span><span class="info">签到</span></li>
                    <li><span>14:00-14:30</span><span class="info">百强地产招标采购管理制度解读与交流</span></li>
                    <li><span>14:30-15:10</span><span class="info">百强地产300+个项目招标信息发布<br>开发商项目招标采购需求发布</span></li>
                    <li><span>15:10-15:30</span><span class="info">问答环节</span></li>
                    <li><span>15:30-16:10</span><span class="info">首届房地产全产业链B2B创新采购展会议介绍</span></li>
                    <li><span>16:10-16:40</span><span class="info">协会集品智库项目介绍</span></li>
                    <li><span>16:40-17:00</span><span class="info">电子问卷回收</span></li>
                    <li><span>17:00-19:30</span><span class="info">晚宴</span></li>
                </ul>
                <div class="btn-group">
                    <input type="submit" class="btn" value="进入问卷调查"/>
                </div>
            </aside>
        </div>
    </div>
    @include('common.error-pop')
    @include('common.loading-pop')
@endsection