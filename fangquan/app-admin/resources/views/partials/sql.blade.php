@if(!empty($query_log))
    <style type="text/css">
        .sql-log {
            width: 100%;
        }

        .sql-log tr td {
            background-color: black !important;
            color: #fff !important;
            text-align: left;
            padding: 5px 10px;
            font-size: 12px !important;
            border: 1px solid #fff;
        }

        .sql-log tr.alert td {
            background-color: #FF6464 !important;
        }

        .sql-log tr:hover td {
            background-color: #00A3D9 !important;
            cursor: pointer;
        }
    </style>
    <table class="sql-log">
        <?php $i = 0; ?>
        <tr>
            <th>序号</th>
            <th>执行时间(ms)</th>
            <th>执行SQL</th>
        </tr>
        @foreach($query_log as $item)
            <tr class="{{$item->time >= 10?'alert':''}}">
                <td>{{++$i}}</td>
                <td>{{$item->time}}</td>
                <td>{{$item->sql}}</td>
            </tr>
        @endforeach
    </table>
@endif
