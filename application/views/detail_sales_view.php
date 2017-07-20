<?php
$total_quantity = 0;
$total_amount = 0;
$total_discounted = 0;
$total_shop_discount = 0;
$payment_received = 0;
$payment_pending = 0;
$payment_remaining = 0;
$check_received = 0;
$unpaid_checks = 0;
$overdue_checks = 0;
$check_amount = 0;
$cash_amount = 0;
$bank_amount = 0;
$returned_amount = 0;
$adjustment_amount = 0;
$unpaid_payment = 0;
?>
<?php $specialDiscount_amount = 0; ?>
<?php $date = date('Y-m-d'); ?>

<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/report/sales_report" method="post">
        <div class="form-group form_distance">
            <label for="shop_name">Shop Name</label>
            <select name="shop_name" id="shop_name" class="shop">
                <option value="">Select</option>
                <?php
                if (isset($record2)) {
                    foreach ($record2 as $row) {
                        ?>
                        <option <?php echo isset($shop_id) ? ($shop_id == $row->id ? 'selected="selected"' : '') : ''; ?> value="<?php echo $row->id ?>"><?php echo $row->shop_name ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group form_distance">
            <input type="submit" name="shop_report" value="Search By Shop" />
        </div>
    </form>
</div>


<div align="center">
    <?php
    if (isset($record)) {
        $specialDiscount_amount = $specialDiscount;
        foreach ($record as $row) {
            $total_quantity = $total_quantity + $row->qty;
            $total_amount = $total_amount + ($row->item_price * $row->qty);
            $total_discounted = $total_discounted + $row->discounted_price;
            $total_shop_discount = $total_shop_discount + ($row->discount * $row->qty);
        }
        foreach ($payment as $row_payment) {
            if ($row_payment->payment_mode == 'check') {
                $check_received++;
            }
            if ($row_payment->payment_mode == 'check' && $row_payment->is_received == 'received') {
                $check_amount = $check_amount + $row_payment->amount;
            } else if ($row_payment->payment_mode == 'cash' && $row_payment->is_received == 'received') {
                $cash_amount = $cash_amount + $row_payment->amount;
            } else if ($row_payment->payment_mode == 'bank_transfer' && $row_payment->is_received == 'received') {
                $bank_amount = $bank_amount + $row_payment->amount;
            } else if ($row_payment->payment_mode == 'returned' && $row_payment->is_received == 'received') {
                $returned_amount = $returned_amount + $row_payment->amount;
            } else if ($row_payment->payment_mode == 'adjustment' && $row_payment->is_received == 'received') {
                $adjustment_amount = $adjustment_amount + $row_payment->amount;
            }
            if ($row_payment->is_received == '0') {
                $unpaid_payment = $unpaid_payment + $row_payment->amount;
            }
            if ($row_payment->is_received == 'received') {
                $payment_received = $payment_received + $row_payment->amount;
            } else {
                //echo $expireDate = new DateTime($row_payment->overdue_date);
                if ($row_payment->payment_mode == 'check' && strtotime($date) >= strtotime($row_payment->overdue_date)) {
                    $overdue_checks++;
                }
                if ($row_payment->payment_mode == 'check') {
                    $unpaid_checks++;
                }
                $payment_pending = $payment_pending + $row_payment->amount;
            }
        }

        $payment_remaining = $total_discounted - $specialDiscount_amount - $payment_received;
        ?>
        <h1>Complete Report of Sales and Payments</h1>
        <div style="width: 790px; float: left; margin-top: 50px; margin-left: 20%;">
            <table style="display: inline-block;">
                <tbody>
                    <tr><th>Quantity Sold</th><td class="td_sale"><?php echo $total_quantity ?></td></tr>
                    <tr><th>Total Amount</th><td class="td_sale"><?php echo $total_amount ?></td></tr>
                    <tr><th>Discount</th><td class="td_sale"><?php echo $total_shop_discount ?></td></tr>
                    <tr><th>Special Discount</th><td class="td_sale"><?php echo $specialDiscount_amount ?></td></tr>
                    <tr><th>Total Discount</th><td class="td_sale"><?php echo ($total_shop_discount + $specialDiscount_amount) ?></td></tr>
                    <tr><th>Payment Pending</th><td class="td_sale"><?php echo $payment_pending ?></td></tr>
                </tbody>
            </table>
            <table style="display: inline-block; padding-left: 160px;">
                <tbody>
                    <tr><th>Check Received</th><td class="td_sale"><?php echo $check_received ?></td></tr>
                    <tr><th>Un-paid Check</th><td class="td_sale"><?php echo $unpaid_checks ?></td></tr>
                    <tr><th>Overdue Checks</th><td class="td_sale"><?php echo $overdue_checks ?></td></tr>
                    <tr><th>Unpaid Payment</th><td class="td_sale"><?php echo $unpaid_payment ?></td></tr>
                </tbody>
            </table>
            <hr width="50%">
            <table style="margin-right: 300px;">
                <tbody>
                    <tr><th>Total Income</th><td class="td_sale"><?php echo $total_discounted - $specialDiscount_amount ?></td></tr>
                    <tr><th>Check</th><td class="td_sale"><?php echo $check_amount ?></td></tr>
                    <tr><th>Cash</th><td class="td_sale"><?php echo $cash_amount ?></td></tr>
                    <tr><th>Bank Transfer</th><td class="td_sale"><?php echo $bank_amount ?></td></tr>
                    <tr><th>Returned</th><td class="td_sale"><?php echo $returned_amount ?></td></tr>
                    <tr><th>Adjustment</th><td class="td_sale"><?php echo $adjustment_amount ?></td></tr>
                    <tr><th>Payment Received</th><td class="td_sale"><?php echo $payment_received ?></td></tr>
                    <tr><th>Remaining Amount</th><td class="td_sale"><?php echo $payment_remaining ?></td></tr>
                </tbody>
            </table>
        </div>
        <?php
    }
    ?>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>