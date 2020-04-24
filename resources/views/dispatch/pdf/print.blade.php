<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>毎日の発送</title>
    <style>
        table, td, th{
            border-collapse: collapse;
        }
        body{
            font-family: ipaexg, sans-serif;
        }
        td, th{
            text-align: center;
        }
    </style>
</head>
<body>
<h1 align="center" style="font-family: ipaexg, sans-serif">{{$params['date']}} 配車板</h1>
<div style="margin: 0 auto; width: 960px">
    <br>
    <table border="1">
        <tr>
            <th width="70">車輌No</th>
            <th width="130">降～当日</th>
            <th width="70">荷主</th>
            <th width="30">空PL</th>
            <th width="130">翌積</th>
            <th width="70">備考</th>
        </tr>
        @foreach($dispatches as $dispatch)
        <tr>
            <td>{{ $dispatch['vehicle_no'] }} <br> {{$dispatch['driver_name']}}</td>
            <td>
                @foreach($dispatch['items'] as $item)
                    {{$item->stack_point}} ~ {{$item->down_point}},
                @endforeach
            </td>
            <td>
                {{$item->shipper_name}}
            </td>
            <td>
                {{$item->empty_pl ? 'はい' : 'なし' }}
            </td>
            <td>
                @if(!empty($dispatch['next_day_items']))
                    @foreach($dispatch['next_day_items'] as $next_item)
                        {{$next_item->stack_point}} ~ {{$next_item->down_point}},
                    @endforeach
                @endif
            </td>
            <td>
                {{$item->item_remark}}
            </td>
        </tr>
        @endforeach
    </table>
</div>
</body>
</html>