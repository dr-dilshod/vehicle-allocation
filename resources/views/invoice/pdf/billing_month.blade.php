<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Billing month</title>
    </head>
    <body>
        <h1 align="center">REPORT</h1>
        <code>
            @foreach($params as $key=>$param)
                {{  $key }} = {{ $param }} <br>
            @endforeach
        </code>
        <div>
            <table align="center" width="100%" style="width:100%">
                <tr>
                    <td>Jap 123-1234</td>
                    <td>19 jan 2020 report</td>
                    <td><strong>bir yaponcha gap</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Yaponcha uzun gap</td>
                    <td>490-1435</td>
                </tr>
                <tr>
                    <td colspan="2">Yaponcha gaplar</td>
                    <td>Yaponcha gaplar</td>
                </tr>
            </table>

            <br>
            <p>Yaponcha uzundan uzoq gaplar</p>
            <table width="100%" style="width:100%" border="1">
                <tr style="background: #444444; color: white">
                    <th>money</th>
                    <th>subtotal</th>
                    <th>count</th>
                    <th>count</th>
                    <th>sales</th>
                    <th>tax</th>
                    <th>driverni poyi</th>
                    <th style="border-top:0;border-bottom:0;width:20px"></th>
                    <th>Total</th>
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
                    <th>money</th>
                    <th>subtotal</th>
                    <th>count</th>
                    <th>count</th>
                    <th>sales</th>
                    <th>tax</th>
                    <th>driverni poyi</th>
                    <th>Kompaniyani poyi</th>
                    <th width="25%">Izohlar</th>
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