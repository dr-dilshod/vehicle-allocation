<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>御請求書</title>
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
        <h1 align="center">御請求書</h1>
        <div>
            <table align="center" width="100%" style="width:100%">
                <tr>
                    <td>{{$shipper_data['shipper_no']}}</td>
                    <td>{{$billing['billing_date']}} </td>
                    <td><strong>{{$shipper_data['shipper_name1']}}</strong></td>
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
            <p>ご利用ありがとうございます。下記の通りご請求申し上げます。</p>
            <table width="100%" style="width:100%" border="1">
                <tr style="background: #444444; color: white">
                    <th>前回御請求額</th>
                    <th>御入金額</th>
                    <th>相殺値引額</th>
                    <th>繰越額</th>
                    <th>当日売上額</th>
                    <th>消費税</th>
                    <th>非課税額</th>
                    <th style="border-top:0;border-bottom:0;width:20px"></th>
                    <th>ご請求額</th>
                </tr>
                <tr>
                    <td>{{$calculations['previous_month_billing']}}</td>
                    <td>{{$calculations['deposit']}}</td>
                    <td>{{$calculations['offset_discount']}}</td>
                    <td>{{$calculations['carry_over_amount']}}</td>
                    <td>{{$calculations['same_day_sales']}}</td>
                    <td>{{$calculations['consumption_tax']}}</td>
                    <td>{{$calculations['tax_free']}}</td>
                    <td style="border-top:0;border-bottom:0;width:20px"></td>
                    <td>{{$calculations['invoice_amount']}}</td>
                </tr>
            </table>

            <br>

            <table width="100%" style="width:100%" border="1">
                <tr style="background: #444444; color: white">
                    <th>日付</th>
                    <th>車輌No</th>
                    <th>発地</th>
                    <th>着地</th>
                    <th>重量</th>
                    <th>単価</th>
                    <th>運賃</th>
                    <th>通行料等</th>
                    <th width="25%">備考</th>
                </tr>
                @foreach($item_data as $item)
                <tr>
                    <td>{{ $item->item_completion_date }}</td>
                    <td>{{ $item->vehicle_no3 }}</td>
                    <td>{{$item->stack_point}}</td>
                    <td>{{$item->down_point}}</td>
                    <td>{{$item->weight}}</td>
                    <td>{{$item->item_price}}</td>
                    <td>{{$item->vehicle_payment}}</td>
                    <td>{{$item->vehicle_payment}}</td>
                    <td>{{$item->item_remark}}</td>
                </tr>
                @endforeach
            </table>
            <hr>
        </div>
    </body>
</html>
