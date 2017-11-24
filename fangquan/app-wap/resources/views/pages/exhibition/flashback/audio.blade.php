<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/flashback/audio')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/flashback/audio')); ?>

@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.header')
    <div class="exhibition-box">
        <div class="exhibition-content">
            <div class="content-box">
                @foreach( ($audio_images ?? []) as $audio_image)
                    <video preload="auto" controls="controls" src="{{$audio_image['audio_url']}}"></video>
                @endforeach
            </div>
        </div>
    </div>
@endsection