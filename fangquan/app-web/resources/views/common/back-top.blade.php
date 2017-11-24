<div class="back-top">
    <ul>
        <li class="feedback">
            <a href="JavaScript:;">
                <i class="iconfont">&#xe6a1;</i>
            </a>

        </li>
        <li class='app-code' style="display: none">
            <a href="JavaScript:;">
                <i class="iconfont">&#xe61c;</i>
            </a>
        </li>
        <li class="backTop">
            <a href="JavaScript:;">
                <i class="iconfont">&#xe6b0;</i>
            </a>
        </li>
    </ul>
    <div class="feedback-box" style="display: none">
        <p>反馈</p>
        <i class="close">X</i>
        <span class="feedback-content">
                  <form id="user-feedback">
                      <div class="textarea" id="textarea">
                        <textarea name="content" placeholder="留下您的建议，我们将不断改进"
                                  data-validation="required length"
                                  data-validation-length="max255"
                                  data-validation-error-msg="请留下您的宝贵建议，长度最大255"></textarea>
                        <span class="text"><var class="area">255</var>/255</span>
                      </div>
                      <div>
                          <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                          <input type="text" name="contact" class="mailbox" placeholder="联系手机" maxlength="50"/>
                          <input type="hidden" name="id" value="{{$id ?? 0}}">
                          <input type="submit" class="btn" value="确定">
                      </div>
                  </form>
              </span>
    </div>
</div>