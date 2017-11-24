<?php App\Wap\Http\Controllers\Resource::addCSS(array('css/exhibition/question/developer-qs')); ?>
<?php App\Wap\Http\Controllers\Resource::addJS(array('app/exhibition/question/developer-qs')); ?>
@extends('layouts.master')
@section('content')
     <div class="main-content">
        <section id="page_index" class="wrap nav-page">
           <p class="qs-info">1. 贵公司感兴趣的创新采购模块（多选）</p>
            <p class="qs-ans"><i class="iconfont" data-val="A">&#xe600;</i><span>A. 养老地产</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="B">&#xe600;</i><span>B. BIM</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="C">&#xe600;</i><span>C. 智能家居</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="D">&#xe600;</i><span>D. 全装修</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="E">&#xe600;</i><span>E. 装配式住宅</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="F">&#xe600;</i><span>F. 特色小镇</span></p>
            <p class="qs-ans other"><i class="iconfont" data-val="G">&#xe600;</i><span>G. 其他</span><input value=""></input></p>
            <p class="qs-ans"><i class="iconfont" data-val="H">&#xe600;</i><span>H. 不感兴趣</span></p>
            <p class="error-info"></p>
            <a href="javascript:void(0);" class="main-btn btnfor-data">下一题</a>
        </section>
        <section id="page_continue" class="wrap nav-page" style="display: none">
            <p class="qs-info">2. 12月6日的创新采购展中，更期待哪个模块？（多选）</p>
            <p class="qs-ans"><i class="iconfont" data-val="A">&#xe600;</i><span>A. 万科采筑平台发布</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="B">&#xe600;</i><span>B. 万科采购总解读并分享万科内部采购流程及管控</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="C">&#xe600;</i><span>C. 碧桂园主导解读五大创新模块以及相关产品技术展示 – 特色小镇、养老地产、BIM、智能家居、装配式住宅</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="D">&#xe600;</i><span>D. 产品品牌对标（招标采购管理制度对标）</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="E">&#xe600;</i><span>E. 活动现场地产项目需求对接</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="F">&#xe600;</i><span>F. 工程主销爆款产品发布</span></p>
            <p class="qs-ans"><i class="iconfont" data-val="G">&#xe600;</i><span>G. 结识优秀供应商负责人</span></p>
            <p class="qs-ans other"><i class="iconfont" data-val="H">&#xe600;</i><span>H. 其他</span><input value=""></input></p>
            <p class="error-info"></p>
            <a href="javascript:void(0);" class="main-btn btnfor-data">下一题</a>
        </section>
        <section id="page_continue" class="wrap nav-page" style="display: none">
            <p class="qs-info">3. 对携带自有地产项目参加12月6日的创新采购展有哪些需求与意见？</p>
            <textarea class="txt-ans"></textarea>
            <p class="error-info"></p>
            <a href="javascript:void(0);" class="main-btn-ex">下一题</a>
        </section>
        <section id="page_continue" class="result-box" style="display: none">
            <p class="qs-info">4. 活动对接联系人信息填写（单选）</p>
            <p class="connect-self connect-choose"><i class="iconfont connect-checked" data-val="1">&#xe606;</i><span>对接人即本人</span></p>
            <p class="connect-other connect-choose"><i class="iconfont" data-val="2">&#xe672;</i><span>对接人非本人（请填写以下信息）</span></p>
            <p class="qs-other"><span>姓名：</span><input class="name" value=""></input></p>
            <p class="qs-other"><span>联系方式：</span><input class="phone" value=""></input></p>
            <p class="qs-other"><span>职位：</span><input class="job" value=""></input></p>
            <p class="reason"><i class="iconfont">&#xe600;</i>若不愿意参加活动，请填写原因</p>
            <textarea type="" class="txt-ans txt-reason"></textarea>
            <p class="error-info"></p>
            <a href="javascript:void(0);" class="result-btn">完成</a>
        </section>
    </div>
@endsection