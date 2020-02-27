<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>御請求書</title>
        <style>
            table.border, .border tr, .border td, .border th{
                border: 1px solid #222222;
            }
            .border td, .border th{
                text-align: center;
            }
            body{
                font-family: ipaexg, sans-serif;
            }
            td{
                padding: 10px 5px;
            }
        </style>
    </head>
    <body>
        <h1 align="center">御請求書</h1>
        <div>
            <table style="width:100%" cellspacing="0">
                <tr>
                    <td width="33%">{{$shipper_data['shipper_no']}}</td>
                    <td style="text-align: center">{{$billing['billing_date']}} </td>
                    <td width="33%"><strong>{{$shipper_data['shipper_name1']}}</strong></td>
                </tr>
                <tr>
                    <td colspan="2">{{$shipper_data['address1']}}</td>
                    <td>{{$shipper_data['postal_code']}}</td>
                </tr>
                <tr>
                    <td colspan="2">{{$shipper_data['address2']}}</td>
                    <td>{{$shipper_data['shipper_name2']}} {{$shipper_data['shipper_kana_name1']}}</td>
                </tr>
            </table>
            <br>
            <div style="padding-left: 100px; height: 90px;">
                <p>ご利用ありがとうございます。下記の通りご請求申し上げます。</p>
                <table width="80%" style="float:left; font-size: 12px; border-spacing: 0" class="border">
                    <tr style="background: #222222; color: white">
                        <th>前回御請求額</th>
                        <th>御入金額</th>
                        <th>相殺値引額</th>
                        <th>繰越額</th>
                        <th>当日売上額</th>
                        <th>消費税</th>
                        <th>非課税額</th>
                    </tr>
                    <tr>
                        <td>{{number_format($calculations['previous_month_billing'])}}</td>
                        <td>{{number_format($calculations['deposit'])}}</td>
                        <td>{{number_format($calculations['offset_discount'])}}</td>
                        <td>{{number_format($calculations['carry_over_amount'])}}</td>
                        <td>{{number_format($calculations['same_day_sales'])}}</td>
                        <td>{{number_format($calculations['consumption_tax'])}}</td>
                        <td>{{number_format($calculations['tax_free'])}}</td>
                    </tr>
                </table>
                <table width="15%" style="float:right; font-size: 12px; border-spacing: 0" class="border">
                    <tr style="background: #222222; color: white">
                        <th>ご請求額</th>
                    </tr>
                    <tr>
                        <td>{{number_format($calculations['invoice_amount'])}}</td>
                    </tr>
                </table>
            </div>

            <br>

            <table width="100%" class="border" cellspacing="0" style="font-size: 12px">
                <tr style="background: #222222; color: white">
                    <th width="5%">日付</th>
                    <th width="8%">車輌No</th>
                    <th width="15%">発地</th>
                    <th width="15%">着地</th>
                    <th width="5%">重量</th>
                    <th width="10%">単価</th>
                    <th width="8%">運賃</th>
                    <th width="8%">通行料等</th>
                    <th width="25%">備考</th>
                </tr>
                @foreach($item_data as $item)
                <tr>
                    <td>{{$item->item_completion_date }}</td>
                    <td>{{$item->vehicle_no3 }}</td>
                    <td>{{$item->stack_point}}</td>
                    <td>{{$item->down_point}}</td>
                    <td>{{number_format($item->weight)}}車</td>
                    <td>{{number_format($item->item_price)}}</td>
                    <td>{{number_format($item->vehicle_payment)}}</td>
                    <td>{{number_format($item->vehicle_payment)}}</td>
                    <td>{{$item->item_remark}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
