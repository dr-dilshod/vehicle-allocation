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
        td{
            text-align: center;
        }
    </style>
</head>
<body>
<h1 align="center" style="font-family: ipaexg, sans-serif">{{$params['date']}}の毎日のディスパッチ出力</h1>
<div>
    <br>
    <table width="100%" style="width:100%" border="1">
        <tr>
            <th>車輌No</th>
            <th>降～当日</th>
            <th>荷主</th>
            <th>空PL</th>
            <th>翌積</th>
            <th>備考</th>
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
                {{$item->empty_pl ? 'Yes' : 'None' }}
            </td>
            <td>

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