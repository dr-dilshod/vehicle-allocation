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
    <table border="1" style="width: 700px; table-layout: fixed">
        <tr>
            <th width="15%">車輌No</th>
            <th width="20%">降～当日</th>
            <th width="12%">荷主</th>
            <th width="8%">空PL</th>
            <th width="20%">翌積</th>
            <th width="25%">備考</th>
        </tr>
        @foreach($dispatches as $dispatch)
        <tr>
            <td>{{ $dispatch->vehicle_no3 }} <br> {{$dispatch->driver_name}}</td>
            <td>
                {{$dispatch->stack_point}} ~ {{$dispatch->down_point}}
            </td>
            <td>
                {{$dispatch->shipper_name}}
            </td>
            <td>
                {{$dispatch->empty_pl ? 'はい' : 'なし' }}
            </td>
            <td>

            </td>
            <td>
                {{$dispatch->item_remark}}
            </td>
        </tr>
        @endforeach
    </table>
</div>
</body>
</html>