<script type="text/html" id="productTpl">
    <div class="product-category">
        <p class="cancel-top">x</p>
        <div class="dialog-header">选择产品类别</div>
        <div class="dialog-content">
            @foreach($product_categories ?? [] as $product_category)
                <div class="dialog_wrap">
                    <span>{{$product_category['name']}}</span>
                    <ul class="list">
                    @foreach($product_category['nodes'] ?? [] as $node)
                            <li>
                                <input id="product_category_{{$node['id']}}" data-id="{{$node['id']}}"
                                    @foreach($product_category_ids ?? [] as $ids)
                                        @if($node['id'] == $ids)checked="checked"@endif
                                    @endforeach
                                       class="type-detail" type="checkbox"
                                       name="select"
                                       value="<?= $node['name'] ?>"/>
                                <label for="product_category_<?= $node['id'] ?>"><?= $node['name'] ?></label>
                            </li>
                       @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="dialog-footer">
            <a href="javascript:;" class="button cancel" id="select-confirm">确定</a>
            <span class="error">主营产品最多选择5个</span>
        </div>
    </div>
</script>