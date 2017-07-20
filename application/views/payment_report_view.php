<?php
$amount_paid = 0;
$check_amount = 0;
$cash_amount = 0;
$bank_amount = 0;
$returned_amount = 0;
$adjustment_amount = 0;
$check_received = 0;
$payment_received = 0;
$unpaid_checks = 0;
$overdue_checks = 0;
$unpaid_payment = 0;
$date = date('Y-m-d');
$payment_pending = 0;
?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/report/payment_report" method="post">
        <div class="form-group form_distance">
            <label for="date">From Date</label>
            <input id="datepicker" type="text" name="fromdate" placeholder="yyyy-mm-dd" value="<?php echo isset($fromDate) ? $fromDate : ''; ?>">
        </div>
        <div class="form-group form_distance">
            <label for="date">To Date</label>
            <input id="datepicker1" type="text" name="todate" placeholder="yyyy-mm-dd" value="<?php echo isset($toDate) ? $toDate : ''; ?>">
        </div>
        <div class="form-group form_distance">
            <label for="shop_name">Shop Name</label>
            <select name="shop_name" id="shop_name" class="shop">
                <option value="">Select</option>
                <?php
                if (isset($record2)) {
                    ?>
                    <?php
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
            <input type="submit" name="shop_report" value="Search" />
        </div>
    </form>
</div>

<div align="center" style="margin-top: 5%;">
    <?php
    if (isset($record)) {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Shop</th><th>Payment Mode</th><th>Amount</th>
                        <th>Comment</th><th>Received</th><th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->shop_name ?></td>
                            <td><?php echo $row->payment_mode ?></td>
                            <td><?php echo $row->amount ?></td>
                            <td><?php echo $row->comment ?></td>
                            <td><?php echo $row->is_received ?></td>
                            <td><?php echo $row->date ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <?php
    if (isset($pageload_record)) {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Shop</th><th>Payment Mode</th><th>Amount</th>
                        <th>Comment</th><th>Received</th><th>Payment Date</th><th>Overdue Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pageload_record as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->shop_name ?></td>
                            <td><?php echo $row->payment_mode ?></td>
                            <td><?php echo $row->amount ?></td>
                            <td><?php echo $row->comment ?></td>
                            <td><?php echo $row->is_received ?></td>
                            <td><?php echo $row->date ?></td>
                            <td><?php echo $row->overdue_date ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
    <?php
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
            if ($row_payment->payment_mode == 'check' && strtotime($date) >= strtotime($row_payment->overdue_date)) {
                $overdue_checks++;
            }
            if ($row_payment->payment_mode == 'check') {
                $unpaid_checks++;
            }
            $payment_pending = $payment_pending + $row_payment->amount;
        }
    }
    ?>
    <div style="float: left; width:100%; margin-top: 20px;">
        <div style="width : 1000px; margin: 0 auto">
            <div style="float: left">
                <table>
                    <tr><th>Check</th><td class="td_sale"><?php echo $check_amount ?></td></tr>
                    <tr><th>Cash</th><td class="td_sale"><?php echo $cash_amount ?></td></tr>
                    <tr><th>Bank Transfer</th><td class="td_sale"><?php echo $bank_amount ?></td></tr>
                    <tr><th>Returned</th><td class="td_sale"><?php echo $returned_amount ?></td></tr>
                    <tr><th>Adjustment</th><td class="td_sale"><?php echo $adjustment_amount ?></td></tr>
                    <tr><th>Payment Received</th><td class="td_sale"><?php echo $payment_received ?></td></tr>
                </table>
            </div>

            <div style="float: left; margin-left: 200px;">
                <table>
                    <tbody>
                        <tr><th>Check Received</th><td class="td_sale"><?php echo $check_received ?></td></tr>
                        <tr><th>Un-paid Check</th><td class="td_sale"><?php echo $unpaid_checks ?></td></tr>
                        <tr><th>Overdue Checks</th><td class="td_sale"><?php echo $overdue_checks ?></td></tr>
                        <tr><th>Unpaid Payment</th><td class="td_sale"><?php echo $unpaid_payment ?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>