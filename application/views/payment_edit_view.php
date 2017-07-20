<?php $tamount = 0; ?>
<?php $amount_paid = 0; ?>
<?php $found = 0; ?>
<?php $page_load = 0; ?>
<?php $specialDiscount = 0; ?>
<?php $invoice = 0; ?>
<div align="center" class="main_top">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/item_sales/payment_invoice_edit" method="post">
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

    <div style="width:1200px !important" class="table-responsive">
        <table class="table" id="addrow" border="1">
            <tr><th>Shop Name</th><th>Payment Mode</th><th>Amount paid</th><th>Date</th><th>Comment</th>
                <th>Is Received</th><th>Overdue Date</th><th>Action</th></tr>
            <?php
            if (isset($payment_record))
            {
                $page_load = 1;
                foreach ($payment_record as $row)
                {
                    $found = 1;
                    ?>
                    <tr>
                        <td>
                            <?php echo $shop_name; ?>
                        </td>
                        <td>
                            <select class="payment_mode" id="payment<?php echo $row->id; ?>" data-id="<?php echo $row->id; ?>" name="payment_mode" form="form<?php echo $row->id; ?>">
                                <?php
                                if ($row->payment_mode == 'check')
                                {
                                    ?>
                                    <option selected value="check">Check</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="returned">Returned</option>
                                    <option value="adjustment">Adjustment</option>
                                    <?php
                                }
                                else if ($row->payment_mode == 'cash')
                                {
                                    ?>
                                    <option value="check">Check</option>
                                    <option selected value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="returned">Returned</option>
                                    <option value="adjustment">Adjustment</option>
                                    <?php
                                }
                                else if ($row->payment_mode == 'bank_transfer')
                                {
                                    ?>
                                    <option value="check">Check</option>
                                    <option value="cash">Cash</option>
                                    <option selected value="bank_transfer">Bank Transfer</option>
                                    <option value="returned">Returned</option>
                                    <option value="adjustment">Adjustment</option>
                                    <?php
                                }
                                else if($row->payment_mode == 'returned')
                                {
                                    ?>
                                    <option value="check">Check</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option selected value="returned">Returned</option>
                                    <option value="adjustment">Adjustment</option>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <option value="check">Check</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="returned">Returned</option>
                                    <option selected value="adjustment">Adjustment</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input form="form<?php echo $row->id ?>" type="text" name="amount" value="<?php echo $row->amount; ?>">
                        </td>
                        <td>
                            <input form="form<?php echo $row->id ?>" id="datepicker" type="text" name="date" placeholder="yyyy-mm-dd" value="<?php echo $row->date; ?>">
                        </td>
                        <td>
                            <textarea form="form<?php echo $row->id ?>" name="comment"><?php echo $row->comment; ?></textarea>
                        </td>
                        <td>
                            <?php
                            if ($row->is_received == 'received')
                            {
                                ?>
                                <input form="form<?php echo $row->id ?>" checked id="checkbox" type="checkbox" name="payment_received" value="received">
                                <?php
                            }
                            else
                            {
                                ?>
                                <input form="form<?php echo $row->id ?>" id = "checkbox" type = "checkbox" name = "payment_received" value = "received">
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <input form="form<?php echo $row->id ?>" id="overdue<?php echo $row->id; ?>" type="text" name="overdue_date" placeholder="yyyy-mm-dd" value="<?php echo $row->overdue_date; ?>">
                        </td>
                        <td class="new-action">
                            <div>
                                <div style="float:left">
                                    <form action="<?php echo site_url() ?>/item_sales/update_payment" method="post" id="form<?php echo $row->id ?>">
                                        <input type="hidden" name="payment_id" value="<?php echo $row->id; ?>">
                                        <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                                        <input class="btn btn-warning" type="submit" name="item" value="Update">
                                    </form>
                                </div>
                                <div style="float: left">
                                    <form action="<?php echo site_url() ?>/item_sales/delete_payment" method="post">
                                        <input type="hidden" name="payment_id" value="<?php echo $row->id; ?>">
                                        <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>">
                                        <input class="btn btn-danger" type="submit" name="item" value="Delete">
                                    </form>
                                </div>
                                <br style="clear: left;" />
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <?php
        if (isset($payment_record) && $found == 1)
        {
            ?>
            <div class="remaining_payment">
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
                echo "Remaining Amount " . ($tamount - $amount_paid - $specialDiscount);
                ?>
            </div>
            <?php
        }
        else if ($page_load == 1)
        {
            echo "No Payment received for this Invoice";
        }
        ?>
    </div>
</div>

<script>
    $(document).on('change', '.payment_mode', function() {
        var id = $(this).data('id');
        var sel = document.getElementById('payment' + id);
        var value = sel.options[sel.selectedIndex].value;
        if (value == 'check')
        {
            $('#overdue' + id).css('border-color', 'red');
        }
        else
        {
            $('#overdue' + id).val('0000-00-00');
        }
    });
</script>