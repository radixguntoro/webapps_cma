<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Export Excel</title>
        <style>
            table.table-border > tr > th {
                text-align: center;
                border: 1px solid #333;
            }

            table.table-border > tr > td {
                border: 1px solid #333;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .text-uppercase {
                text-transform: uppercase;
            }

            .text-capitalize {
                text-transform: capitalize;
            }

            .font-bold {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <th colspan="3">STOCK OPNAME REWARD REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Item Name</th>
                <th class="text-center">Selling Price</th>
                <th class="text-center">Qty System</th>
                <th class="text-center">Qty Physic</th>
                <th class="text-center">Stock Difference</th>
                <th class="text-center">Price Difference</th>
            </tr>
            @foreach ($data_excel as $key => $value):
                <tr>
                    <td>{{ onlyDate($value['date']) }}</td>
                    <td>{{ $value['name'] }}</td>
                    <td class="text-right">{{ $value['price_sell_app'] }}</td>
                    <td class="text-right">{{ $value['stock_in_system'] }}</td>
                    <td class="text-right">{{ $value['stock_in_physic'] }}</td>
                    <td class="text-right">{{ $value['stock_difference'] }}</td>
                    <td class="text-right">{{ $value['price_sell_difference'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-right">Total</td>
                <td class="text-right font-bold">
                    @php
                        ($grand_total = 0)
                    @endphp
                    @foreach ($data_excel as $key => $value)
                        @php $grand_total += $value['price_sell_difference'] @endphp
                    @endforeach
                    {{ $grand_total }}
                </td>
            </tr>
        </table>
    </body>
</html>
