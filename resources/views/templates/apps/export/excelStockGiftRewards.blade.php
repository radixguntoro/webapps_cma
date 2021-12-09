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
                <th colspan="4">STOCK GIFT REWARD REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Gift Name</th>
                <th class="text-center">Stamp</th>
                <th class="text-center">Quantity</th>
            </tr>
            @foreach ($data_excel as $key => $value):
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="text-uppercase">{{ $value['name'] }}</td>
                    <td class="text-capitalize">{{ $value['stamp'] }}</td>
                    <td class="text-right">{{ $value['qty'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="text-right">Total</td>
                <td class="text-right font-bold">
                    @php
                        ($total_stamp = 0)
                    @endphp
                    @foreach ($data_excel as $key => $value)
                        @php $total_stamp += $value['stamp'] @endphp
                    @endforeach
                    {{ $total_stamp }}
                </td>
                <td class="text-right font-bold">
                    @php
                        ($total_qty = 0)
                    @endphp
                    @foreach ($data_excel as $key => $value)
                        @php $total_qty += $value['qty'] @endphp
                    @endforeach
                    {{ $total_qty }}
                </td>
            </tr>
        </table>
    </body>
</html>
