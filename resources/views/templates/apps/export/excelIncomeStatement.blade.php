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
                <th colspan="3">INCOME STATEMENT REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">Periode Date</th>
                <th class="text-center">Category</th>
                <th class="text-center">Total Payment</th>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Tuition</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_tuition'] }}</td>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Books</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_book'] }}</td>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Accessory</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_accessory'] }}</td>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Deposit Books</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_deposit'] }}</td>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Purchase Order Inventory</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_poi'] }}</td>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Purchase Order Reward</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_por'] }}</td>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Stock Opname Inventory</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_soi'] }}</td>
            </tr>
            <tr>
                <td>{{ $data_excel['periode_datestart'] }} - {{ $data_excel['periode_dateend'] }}</td>
                <td>Stock Opname Reward</td>
                <td class="font-bold text-right">{{ $data_excel['total_income_sor'] }}</td>
            </tr>
        </table>
    </body>
</html>
