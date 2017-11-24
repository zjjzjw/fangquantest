(function($) {
  $.fn.structure = function(options) {
    var opts = $.extend({}, $.fn.structure.defaults, options);
    var $appendTo = $(opts.chartElement);//图形放置位置

    // 绘图
    $this = $(this);
    var $container = $("<div class='" + opts.chartClass + "'/>");
    if($this.is("ul")) {
      buildNode($this.find("li:first"), $container, 0, opts);
    }
    else if($this.is("li")) {
      buildNode($this, $container, 0, opts);
    }
    $appendTo.append($container);//图形插入
  };

  // Option defaults
  $.fn.structure.defaults = {
    chartElement : 'body',//图形放置位置
    depth      : -1,
    chartClass : "structure"//图形实现的class($container)
  };

  var nodeCount = 0;
  // 递归建树
  function buildNode($node, $appendTo, level, opts) {
    var $table = $("<table/>");
    var $tbody = $("<tbody/>");
    var $nodeRow = $("<tr/>").addClass("node-cells");//行
    var $nodeCell = $("<td/>").addClass("node-cell").attr("colspan", 2);//单元格
    var $childNodes = $node.children("ul:first").children("li");//
    var $nodeDiv;
    //设置node-cell长度
    if($childNodes.length > 1) {
      $nodeCell.attr("colspan", $childNodes.length * 2);
    }
    // 获取ul，li内容
    var $nodeContent = $node.clone().children("ul,li").remove().end().html();

    nodeCount++;
    $node.data("tree-node", nodeCount);
    $nodeDiv = $("<div>").addClass("node").data("tree-node", nodeCount).append($nodeContent);

    $nodeCell.append($nodeDiv);
    $nodeRow.append($nodeCell);
    $tbody.append($nodeRow);

    if($childNodes.length > 0) {
      if(opts.depth == -1 || (level+1 < opts.depth)) {
        var $downLineRow = $("<tr/>");
        var $downLineCell = $("<td/>").attr("colspan", $childNodes.length*2);
        $downLineRow.append($downLineCell);
        $downLine = $("<div></div>").addClass("line down");
        $downLineCell.append($downLine);
        $tbody.append($downLineRow);

        var $linesRow = $("<tr/>");
        $childNodes.each(function() {
          var $left = $("<td>&nbsp;</td>").addClass("line left top");
          var $right = $("<td>&nbsp;</td>").addClass("line right top");
          $linesRow.append($left).append($right);
        });

        $linesRow.find("td:first").removeClass("top").end().find("td:last").removeClass("top");

        $tbody.append($linesRow);
        var $childNodesRow = $("<tr/>");
        $childNodes.each(function() {
           var $td = $("<td class='node-container'/>");
           $td.attr("colspan", 2);
           buildNode($(this), $td, level+1, opts);
           $childNodesRow.append($td);
        });

      }
      $tbody.append($childNodesRow);
    }
    if ($node.attr('class') != undefined) {
        var classList = $node.attr('class').split(/\s+/);
        $.each(classList, function(index,item) {
            if (item == 'collapsed') {
                $nodeRow.nextAll('tr').css('visibility', 'hidden');
                    $nodeRow.removeClass('expanded');
                    $nodeRow.addClass('contracted');
            } else {
                $nodeDiv.addClass(item);
            }
        });
    }

    $table.append($tbody);
    $appendTo.append($table);
  };

})(jQuery);
