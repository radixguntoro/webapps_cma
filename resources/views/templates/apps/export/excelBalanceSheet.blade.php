<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Export Excel</title>
        <style>
            table.table-border {
                border-collapse: collapse;
            }

            table.table-border > tr > th {
                text-align: center;
                border: 1px solid #333;
            }

            table.table-border > tr > td {
                border: 1px solid #333;
                padding: 4px 6px;
            }

            table.table-border > tbody > tr > td {
                border: 1px solid #333;
                padding: 4px 6px;
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

            .no-border {
                border: 0 !important;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <th colspan="4">BALANCE SHEET REPORT</th>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <td colspan="4" class="no-border font-bold text-center">Students</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td colspan="4" class="no-border font-bold text-center">Rewards</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td colspan="4" class="no-border font-bold text-center">Vouchers</td>
            </tr>
            <tr>
                <td colspan="2">Active</td>
                <td colspan="2">Non Active</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td colspan="2">Active</td>
                <td colspan="2">Non Active</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td colspan="2">Active</td>
                <td colspan="2">Non Active</td>
            </tr>
            <tr>
                <td>Qty</td>
                <td class="text-right">{{ $data_excel['count_student_active'] }}</td>
                <td>Qty</td>
                <td class="text-right">{{ $data_excel['count_student_nonactive'] }}</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Qty</td>
                <td class="text-right">{{ $data_excel['count_reward_active'] }}</td>
                <td>Qty</td>
                <td class="text-right">{{ $data_excel['count_reward_nonactive'] }}</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Qty</td>
                <td class="text-right">{{ $data_excel['count_voucher_active'] }}</td>
                <td>Qty</td>
                <td class="text-right">{{ $data_excel['value_voucher_nonactive'] }}</td>
            </tr>
            <tr>
                <td>Deposit</td>
                <td class="text-right">{{ $data_excel['deposit_student_active'] }}</td>
                <td>Deposit</td>
                <td class="text-right">{{ $data_excel['deposit_student_nonactive'] }}</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Deposit</td>
                <td class="text-right">{{ $data_excel['price_reward_active'] }}</td>
                <td>Deposit</td>
                <td class="text-right">{{ $data_excel['price_reward_nonactive'] }}</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Deposit</td>
                <td class="text-right">{{ $data_excel['value_voucher_active'] }}</td>
                <td>Deposit</td>
                <td class="text-right">{{ $data_excel['value_voucher_nonactive'] }}</td>
            </tr>
        </table>
        <table class="table-border">
            <tr>
                <td colspan="14" class="no-border font-bold text-center">Inventory</td>
            </tr>
            <tr>
                <td>Active</td>
                <td>Qty</td>
                <td colspan="2">Buying Price</td>
                <td colspan="2">Selling Price</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Non Active</td>
                <td>Qty</td>
                <td colspan="2">Buying Price</td>
                <td colspan="2">Selling Price</td>
            </tr>
            <tr>
                <td>Books</td>
                <td class="text-right">{{ $data_excel['inventory_book_qty_active'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_book_buying_active'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_book_selling_active'] }}</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Books</td>
                <td class="text-right">{{ $data_excel['inventory_book_qty_nonactive'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_book_buying_nonactive'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_book_selling_nonactive'] }}</td>
            </tr>
            <tr>
                <td>Accessory</td>
                <td class="text-right">{{ $data_excel['inventory_accessory_qty_active'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_accessory_buying_active'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_accessory_selling_active'] }}</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Accessory</td>
                <td class="text-right">{{ $data_excel['inventory_accessory_qty_nonactive'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_accessory_buying_nonactive'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_accessory_selling_nonactive'] }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="text-right">{{ $data_excel['inventory_book_qty_active'] + $data_excel['inventory_accessory_qty_active'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_accessory_qty_active'] + $data_excel['inventory_accessory_buying_active'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_book_selling_active'] + $data_excel['inventory_accessory_selling_active'] }}</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td class="no-border font-bold text-center" width="10">&nbsp;</td>
                <td>Total</td>
                <td class="text-right">{{ $data_excel['inventory_book_qty_nonactive'] + $data_excel['inventory_accessory_qty_nonactive'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_accessory_qty_nonactive'] + $data_excel['inventory_accessory_buying_nonactive'] }}</td>
                <td class="text-right" colspan="2">{{ $data_excel['inventory_book_selling_nonactive'] + $data_excel['inventory_accessory_selling_nonactive'] }}</td>
            </tr>
        </table>
    </body>
</html>
