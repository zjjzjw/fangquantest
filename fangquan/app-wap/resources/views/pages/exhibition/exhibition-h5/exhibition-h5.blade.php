<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/exhibition-h5/exhibition-h5')); ?>
  <?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/exhibition-h5/exhibition-h5')); ?>
@extends('layouts.master')
@section('content')
    @include('partials.exhibition-h5.header')
    @include('partials.exhibition-h5.footer')
@endsection