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
                <th colspan="2">PAYMENT REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Invoice</th>
                <th class="text-center">Student Name</th>
                <th class="text-center">Student ID</th>
                <th class="text-center">Transaction</th>
                <th class="text-center">Category</th>
                <th class="text-center">Tuition</th>
                <th class="text-center">Deposit Book</th>
                <th class="text-center">Inventory</th>
                <th class="text-center">Discount (%)</th>
                <th class="text-center">Voucher</th>
                <th class="text-center">Cash</th>
                <th class="text-center">Debit</th>
                <th class="text-center">Transfer</th>
                <th class="text-center">Total</th>
                <th class="text-center">Note</th>
            </tr>
            @foreach ($data_excel as $key => $value):
                <tr>
                    <td>{{ onlyDate($value['date']) }}</td>
                    <td>{{ $value['invoice'] }}</td>
                    <td>{{ $value['student_name'] }}</td>
                    <td>{{ $value['student_id'] }}</td>
                    <td>{{ $value['transaction'] }}</td>
                    <td>{{ $value['category'] }}</td>
                    <td class="text-right">{{ $value['tuition'] != '' ? $value['tuition'] : '' }}</td>
                    <td class="text-right">{{ $value['deposit_book'] != '' ? $value['deposit_book'] : '' }}</td>
                    <td class="text-right">{{ $value['inventory'] != '' ? $value['inventory'] : '' }}</td>
                    <td class="text-right">{{ $value['disc'] }}</td>
                    <td class="text-right">{{ $value['discount_voucher'] }}</td>
                    <td class="text-right">{{ $value['cash'] }}</td>
                    <td class="text-right">{{ $value['debit'] }}</td>
                    <td class="text-right">{{ $value['transfer'] }}</td>
                    <td class="text-right">{{ $value['total'] }}</td>
                    <td class="text-center">{{ $value['note'] }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
