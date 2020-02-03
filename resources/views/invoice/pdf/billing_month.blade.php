<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Your Invoice</title>
    </head>
    <body>
        <h1 align="center">Your Invoice</h1>
        <code>
            @foreach($params as $key=>$param)
                {{  $key }} = {{ $param }} <br>
            @endforeach
        </code>
        <div>
            <table align="center" width="100%" style="width:100%">
                <tr>
                    <td>Postal code: </td>
                    <td>Closing date: </td>
                    <td><strong>[Shoei Transportation Co., Ltd.]</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Address:</td>
                    <td>490-1435</td>
                </tr>
                <tr>
                    <td colspan="2">[address]</td>
                    <td>[shipper name]</td>
                </tr>
            </table>

            <br>
            <p>Thanks. We will charge as follows.</p>
            <table width="100%" style="width:100%" border="1">
                <tr style="background: #444444; color: white">
                    <th>Previous billing amount</th>
                    <th>Deposit</th>
                    <th>Offset discount</th>
                    <th>Carryover amount</th>
                    <th>Same-day sales</th>
                    <th>Consumption tax</th>
                    <th>Tax exemption</th>
                    <th style="border-top:0;border-bottom:0;width:20px"></th>
                    <th>Invoice amount</th>
                </tr>
                <tr>
                    <td>248.000</td>
                    <td>248.000</td>
                    <td>248.000</td>
                    <td>248.000</td>
                    <td>248.000</td>
                    <td>248.000</td>
                    <td>248.000</td>
                    <td style="border-top:0;border-bottom:0;width:20px"></td>
                    <td>248.000</td>
                </tr>
            </table>

            <br>

            <table width="100%" style="width:100%" border="1">
                <tr style="background: #444444; color: white">
                    <th>Date</th>
                    <th>Vehicle No</th>
                    <th>Departure place</th>
                    <th>Landing</th>
                    <th>Weight</th>
                    <th>Unit price</th>
                    <th>Fares</th>
                    <th>Tolls, etc.</th>
                    <th width="25%">Remarks</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <br>

            <hr>
        </div>
    </body>
</html>
