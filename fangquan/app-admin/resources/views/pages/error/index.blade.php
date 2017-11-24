<?php
ufa()->extCss([
        'error/index'
]);
ufa()->extJs([
        'error/index',
]);
?>
@extends('layouts.master')
@section('master.content')
    @if (count($errors) > 0)
        <p class="error-alert">
            @foreach ($errors->all() as $key => $error)
                {{$key + 1}}、 {{ $error }}
            @endforeach
        </p>
    @endif
@endsection