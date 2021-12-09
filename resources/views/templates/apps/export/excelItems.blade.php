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
                <th colspan="4">BOOK & INVENTORY REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Item Name </th>
                <th class="text-center">Category </th>
                <th class="text-center">Qty </th>
                <th class="text-center">Buying Price </th>
                <th class="text-center">Selling Price </th>
                <th class="text-center">Buying Price Total</th>
                <th class="text-center">Selling Price Total</th>
            </tr>
            @foreach ($data_excel as $key => $value):
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="text-uppercase">{{ $value['name'] }}</td>
                    <td class="text-capitalize">{{ $value['category'] }}</td>
                    <td class="text-right">{{ $value['qty'] }}</td>
                    <td class="text-right">{{ $value['price_buy'] }}</td>
                    <td class="text-right">{{ $value['price_sell'] }}</td>
                    <td class="text-right">{{ $value['price_buy'] * $value['qty'] }}</td>
                    <td class="text-right">{{ $value['price_sell'] * $value['qty'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-right">Total</td>
                <td class="text-right font-bold">
                    @php
                        ($total_price_buy = 0)
                    @endphp
                    @foreach ($data_excel as $key => $value)
                        @php $total_price_buy += $value['price_buy'] * $value['qty'] @endphp
                    @endforeach
                    {{ $total_price_buy }}
                </td>
                <td class="text-right font-bold">
                    @php
                        ($total_price_sell = 0)
                    @endphp
                    @foreach ($data_excel as $key => $value)
                        @php $total_price_sell += $value['price_sell'] * $value['qty'] @endphp
                    @endforeach
                    {{ $total_price_sell }}
                </td>
            </tr>
        </table>
    </body>
</html>
