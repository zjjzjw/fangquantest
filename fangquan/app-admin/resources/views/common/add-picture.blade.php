<div class="picture-box picture-box-{{$name}}">
    <div class="picture-item">
        <div class="show">
            @if (!empty($images))
                @if (!empty(current($images)['image_id']))
                    @foreach ($images as $image)
                        <div class="show-item">
                            <span class="delete">X</span>
                            <a href="{{$image['url']}}" target="_blank"></a>
                            <img src="{{$image['url']}}?imageView2/1/w/200/h/200">
                            <input type="hidden" name="{{$name}}{{empty($single) ? '[]' : ''}}"
                                   value="{{$image['image_id']}}">
                        </div>
                    @endforeach
                @endif
            @endif

            {{--添加图片的按钮--}}
            <div class="add add-{{$name}}"
                 style="@if ((empty(current($images)['image_id']) && !empty($single)) || empty($single)) display:inline-block; @else display:none @endif">
                <p class="add-img">十</p>
                <p>{{$tips}}</p>
                <input type="file" id="addPicture-{{$name}}" name="file" class="add-img-click"
                       @if (empty($single))
                       multiple="multiple"
                        @endif
                />
            </div>

        </div>
    </div>
</div>
