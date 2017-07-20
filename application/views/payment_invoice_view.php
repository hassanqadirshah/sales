<?php $tamount = 0; ?>
<?php $amount_paid = 0; ?>
<?php $specialDiscount = 0; ?>
<?php $date = date("Y-m-d"); ?>
<?php $invoice = 0; ?>
<div align="center" class="main_top">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/item_sales/add_payment_invoice" method="post">
        <div class="form-group form_distance">
            <label for="shop_name">Select Shop:</label>
            <select name="shop_name">
                <option value="">Select</option>
                <?php
                if (isset($record2))
                {
                    foreach ($record2 as $row)
                    {
                        ?>
                <option <?php echo isset($shop_id) ? ($shop_id==$row->id ? 'selected="selected"' : '') : ''; ?> value="<?php echo $row->id ?>"><?php echo $row->shop_name ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group form_distance">
            <input type="submit" value="Search" />
        </div>
    </form>
</div>

<div align="center" style="margin-top: 40px;">

    <div style="width:1000px !important" class="table-responsive">
        <table class="table" id="addrow" border="1">
            <tr><th>Shop Name</th><th>Total Amount</th><th>Amount Payed</th><th>Remaining Amount</th></tr>
            <?php
            if (isset($record))
            {
                ?>
                <tr>
                    <td>
                        <?php echo $shop_name; ?>
                    </td>

                    <td>
                        <?php
                        foreach ($discount_price as $row_discount)
                        {
                            $amount_paid = $amount_paid + $row_discount->amount;
                        }
                        foreach ($amount as $row_amount)
                        {
                            $tamount = $tamount + $row_amount->discounted_price;
                            if($row_amount->invoice != $invoice)
                            {
                                $specialDiscount = $specialDiscount + $row_amount->specialDiscount;
                                $invoice = $row_amount->invoice;
                            }
                        }
                        echo $tamount - $specialDiscount;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $amount_paid;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $tamount - $amount_paid - $specialDiscount;
                        ?>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>

    <div style="width:1000px !important" class="table-responsive">
        <form action="<?php echo site_url() ?>/item_sales/insert_payment" method="post">

            <table class="table" id="addrow" border="1">
                <tr><th>Payment Mode</th><th>Amount</th><th>Comment</th><th>Is Received</th><th>Receiving Date</th>
                    <th id="overdue">Overdue Date</th></tr>
                <tr>
                    <td>
                        <select name="payment_mode" class="payment_mode" id="payment_mode">
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="returned">Returned</option>
                            <option value="adjustment">Adjustment</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="amount" required>
                    </td>
                    <td>
                        <textarea name="comment"></textarea>
                    </td>
                    <td>
                        <input id="checkbox" type="checkbox" name="payment_received" value="received">
                    </td>
                    <td>
                        <input id="datepicker" type="text" name="date" placeholder="yyyy-mm-dd" value="<?php echo $date ?>">
                        <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                    </td>
                    <td id="overduetd">
                        <input id="datepicker1" type="text" name="overdue_date" placeholder="yyyy-mm-dd" value="<?php echo $date ?>">
                    </td>
                </tr>

            </table>
            <input class="btn btn-success" type="submit" name="submit" value="Submit">
        </form>
    </div>

</div>

<script>
    $(document).on('change', '.payment_mode', function() {
        var sel = document.getElementById('payment_mode');
        var value = sel.options[sel.selectedIndex].value;
        if (value == 'check')
        {
            $('#checkbox').prop('checked', false);
            $('#overdue').show();
            $('#overduetd').show();
        }
        else
        {
            $('#checkbox').prop('checked', true);
            $('#overdue').hide();
            $('#overduetd').hide();
        }
    });
</script>