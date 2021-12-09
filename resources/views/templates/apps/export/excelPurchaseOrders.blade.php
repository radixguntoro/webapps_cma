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
                <th colspan="3">PURCHASE ORDER INVENTORY REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Invoice Number</th>
                <th class="text-center">Item Name</th>
                <th class="text-center">Category</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Qty Bonus</th>
                <th class="text-center">Selling Price</th>
                <th class="text-center">Discount</th>
                <th class="text-center">Buying Price</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Note</th>
            </tr>
            @foreach ($data_excel as $key => $value):
                <tr>
                    <td>{{ onlyDate($value['date']) }}</td>
                    <td>{{ $value['invoice'] }}</td>
                    <td>{{ $value['item_name'] }}</td>
                    <td>{{ $value['category'] }}</td>
                    <td class="text-right">{{ $value['qty'] }}</td>
                    <td class="text-right">{{ $value['qty_bonus'] }}</td>
                    <td class="text-right">{{ $value['price_sell'] }}</td>
                    <td class="text-right">{{ $value['discount'] * 100 }}</td>
                    <td class="text-right">{{ $value['price_buy'] }}</td>
                    <td class="text-right">{{ $value['subtotal'] }}</td>
                    <td class="text-center">{{ $value['note'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="9" class="text-right">Total</td>
                <td class="text-right font-bold">
                    @php
                        ($grand_total = 0)
                    @endphp
                    @foreach ($data_excel as $key => $value)
                        @php $grand_total += $value['subtotal'] @endphp
                    @endforeach
                    {{ $grand_total }}
                </td>
                <td class="text-center">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
