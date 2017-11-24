<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/gather/register')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/gather/register')); ?>
@extends('layouts.master')
@section('content')
    <div class="wrapper-box">
        <div class="content-box">
            <div class="bg-image"></div>
            <form id="form" onsubmit="return false">
                <h3 class="title">参会人员登陆注册</h3>
                <div class="form-group">
                    <label class="control-label">姓名</label>
                    <div class="input-group">
                        <input type="text" name="name" value="" maxlength="32"
                               data-required="true"
                               data-descriptions="name"
                               data-describedby="name-description"/>
                    </div>
                    <div id="name-description" class="error-tip"></div>
                </div>
                <div class="form-group">
                    <label class="control-label">公司</label>
                    <div class="input-group">
                        <input type="text" name="company" value=""
                               data-pattern="([\u4e00-\u9fa5]|[0-9a-zA-Z]){2,30}"
                               data-required="true"
                               data-descriptions="company"
                               data-describedby="company-description"/>
                    </div>
                    <div id="company-description" class="error-tip"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">职位</label>
                    <div class="input-group">
                        <input type="text" name="position" value=""
                               data-pattern="([\u4e00-\u9fa5]|[0-9a-zA-Z]){2,30}"
                               data-required="true"
                               data-descriptions="position"
                               data-describedby="position-description"/>
                    </div>
                    <div id="position-description" class="error-tip"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">电话</label>
                    <div class="input-group">
                        <input type="text" name="phone" value=""
                               data-pattern="^1\d{10}$"
                               data-required="true"
                               data-descriptions="phone"
                               data-describedby="phone-description"/>
                    </div>
                    <div id="phone-description" class="error-tip"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">邮箱</label>
                    <div class="input-group">
                        <input type="text" name="email" value=""
                               data-pattern="\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}"
                               data-required="true"
                               data-descriptions="email"
                               data-describedby="email-description"/>
                    </div>
                    <div id="email-description" class="error-tip"></div>
                </div>

                <div class="btn-group">
                    <input type="hidden" name="id" value="0">
                    <input type="submit" class="btn" value="确定"/>
                </div>
            </form>

        </div>
    </div>
    @include('common.loading-pop')
@endsection