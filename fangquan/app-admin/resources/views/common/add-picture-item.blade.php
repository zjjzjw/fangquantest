<script type="text/html" id="files_tpl">
    <div class="show-item">
        <span class="delete">X</span>
        <a href="<%=result.origin_url%>" target="_blank">
            <img src="<%= result.origin_url %>">
        </a>
        <input type="hidden" name="<%=name%><% if(single){%><%}else{%>[]<%}%>" value="<%= result.id %>">
    </div>
</script>