<script type="text/html" id="projectTpl">
    <div class="product-category">
        <p class="cancel-top">x</p>
        <div class="dialog-header">选择产品类别</div>
        <div class="dialog-content">
            @foreach($project_categories ?? [] as $project_category)
                <div class="dialog_wrap">
                    <span>{{$project_category['name']}}</span>
                    <ul class="list">
                        @foreach($project_category['main_category'] ?? [] as $node)
                            <li>
                                <input id="project_category_{{$node['id']}}" data-id="{{$node['id']}}"
                                       @foreach($project_category_ids ?? [] as $ids)
                                       @if($node['id'] == $ids)checked="checked" @endif
                                       @endforeach
                                       class="project-type-detail" type="checkbox"
                                       name="select"
                                       value="<?= $node['name'] ?>"/>
                                <label for="project_category_<?= $node['id'] ?>"><?= $node['name'] ?></label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="dialog-footer">
            <a href="javascript:;" class="button cancel" id="select-project">确定</a>
            <span class="error">主营产品最多选择5个</span>
        </div>
    </div>
</script>