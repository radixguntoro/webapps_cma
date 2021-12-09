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
                <th colspan="2">CHANGE BOOK REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Student Name</th>
                <th class="text-center">Student ID</th>
                <th class="text-center">Category</th>
                <th class="text-center">Invoice Number</th>
                <th class="text-center">New Book</th>
                <th class="text-center">Deposit Balance After</th>
                <th class="text-center">Note</th>
            </tr>
            @foreach ($data_excel as $key => $value):
                <tr>
                    <td>{{ onlyDate($value['date']) }}</td>
                    <td>{{ $value['student_name'] }}</td>
                    <td>{{ $value['student_id'] }}</td>
                    <td>{{ $value['category']  }}</td>
                    <td>{{ $value['invoice']  }}</td>
                    <td class="text-uppercase">{{ $value['new_book']  }}</td>
                    <td class="text-right">{{ $value['deposit_balance'] }}</td>
                    <td class="text-center">{{ $value['note'] }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
