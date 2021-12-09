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
                <th colspan="4">NEW STUDENT REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Join Date</th>
                <th class="text-center">Student Name</th>
                <th class="text-center">Student ID</th>
            </tr>
            @foreach ($data_excel as $key => $value):
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ onlyDate($value['join_date']) }}</td>
                    <td class="text-uppercase">{{ $value['name'] }}</td>
                    <td class="text-capitalize">{{ $value['code'] }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
