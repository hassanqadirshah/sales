<?php $total_amount = 0; ?>
<?php $payment_received = 0; ?>
<?php $total_quantity = 0; ?>
<?php $invoice = 0; ?>
<?php $specialDiscount = 0; ?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/report/shop_report" method="post">
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
                if (isset($record2))
                {
                    ?>
                    <?php
                    foreach ($record2 as $row)
                    {
                        ?>
                        <option <?php echo isset($shop_name) ? ($shop_name==$row->shop_name ? 'selected="selected"' : '') : ''; ?> value="<?php echo $row->shop_name ?>"><?php echo $row->shop_name ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group form_distance">
            <input type="submit" name="shop_report" />
        </div>
    </form>
</div>

<div align="center" style="margin-top: 5%;">
    <?php
    if (isset($record))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Item Name</th><th>Item Price</th><th>Shop Name</th><th>Discount</th>
                        <th>Quantity</th><th>Total Price</th><th>Discount Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->item_name ?></td>
                            <td><?php echo $row->item_price ?></td>
                            <td><?php echo $row->shop_name ?></td>
                            <td><?php echo $row->discount ?></td>
                            <td><?php echo $row->qty ?></td>
                            <td><?php echo $row->qty * $row->item_price ?></td>
                            <td><?php echo $row->discounted_price ?></td>
                        </tr>
                        <?php
                        $total_amount = $total_amount + $row->discounted_price;
                        $total_quantity = $total_quantity + $row->qty;
                        if($row->invoice != $invoice)
                        {
                            $specialDiscount += $row->specialDiscount;
                            $invoice = $row->invoice;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <?php
    if (isset($payment))
    {
        foreach ($payment as $payment_row)
        {
            $payment_received = $payment_received + $payment_row->amount;
        }
        ?>
        <div class="payment">
            <?php
            echo "Special Discount: " . $specialDiscount . '<br>';
            echo 'Total Amount: ' . ($total_amount - $specialDiscount) . '<br>';
            echo 'Total Quantity: ' . $total_quantity . '<br>';
            echo "Payment Received: " . $payment_received . '<br>';
            echo 'Remaining Amount: ' . ($total_amount - $payment_received - $specialDiscount) . '<br>';
            ?>
        </div>
        <?php
    }
    ?>


    <?php
    if (isset($pageload_record))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Item Name</th><th>Item Price</th>
                        <th>Quantity</th><th>Total Price</th><th>Discount Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pageload_record as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->item_name ?></td>
                            <td><?php echo $row->item_price ?></td>
                            <td><?php echo $row->qty ?></td>
                            <td><?php echo $row->qty * $row->item_price ?></td>
                            <td><?php echo $row->discounted_price ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

</div>