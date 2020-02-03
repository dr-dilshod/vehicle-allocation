<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>毎日の発送</title>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <style>
        table, td, th{
            border-collapse: collapse;
        }
        @font-face {
            font-family: 'Noto Sans JP';
            font-style: normal;
            font-weight: normal;
            src: url(https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap) format('truetype');
        }
        body{
            font-family: 'Noto Sans JP', sans-serif;
        }
        td{
            text-align: center;
        }
    </style>
</head>
<body>
<h1 align="center">{{$params['date']}}の毎日のディスパッチ出力</h1>
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