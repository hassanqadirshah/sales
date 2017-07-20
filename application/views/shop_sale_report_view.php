<?php
$specialDiscount = 0;
$appliedDiscount = 0;
$discountedPrice = '';
$total_amount = 0;
$total_qty = 0;
$tamount = 0;
$amount_paid = 0;
$specialDiscount_total = 0;
$invoice = 0;
?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/report/shop_sale_filter" method="post">
        <div class="form-group form_distance">
            <label for="shop_name">Shop Name</label>
            <select name="shop_name">
                <option value="">Select</option>
                <?php
                if (isset($record2)) {
                    ?>
                    <?php
                    foreach ($record2 as $row) {
                        ?>
                        <option value="<?php echo $row->id ?>"><?php echo $row->shop_name ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group form_distance">
            <input type="submit" />
        </div>
    </form>
</div>


<div align="center">

    <h1><?php echo isset($shopName) ? $shopName : ''; ?></h1>
    <div style="width:1000px !important" class="table-responsive">
        <table class="table" border="1">
            <thead>
                <tr>
                    <th>Invoice</th><th>Shop Name</th><th>Quantity</th><th>Original Price</th>
                    <th>Special Discount</th><th>Net Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($record)) {
                    foreach ($record as $row) {
                        ?>
                        <tr>
                            <td><a target="_blank" href="<?php echo base_url() ?>index.php/item_sales/sales_invoice_edit?invoice=<?php echo$row->invoice ?>"><?php echo $row->invoice; ?></a></td>
                            <td><?php echo $row->shop_name; ?></td>
                            <td><?php echo $row->total_qty; ?></td>
                            <td><?php echo $row->applied_discount; ?></td>
                            <td><?php echo $row->specialDiscount; ?></td>
                            <td><?php echo $row->discounted_price; ?></td>
                            <?php
                            $specialDiscount += $row->specialDiscount;
                            $appliedDiscount += $row->applied_discount;
                            $discountedPrice += $row->discounted_price;
                            $total_qty += $row->total_qty;
                            ?>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="width:1000px !important" class="table-responsive">
        <table class="table" border="1">
            <tr><th>Shop Name</th><th>Total Amount</th><th>Amount Payed</th><th>Remaining Amount</th></tr>
            <?php
            if (isset($payment_record)) {
                ?>
                <tr>
                    <td>
                        <?php echo $shopName; ?>
                    </td>

                    <td>
                        <?php
                        foreach ($discount_price as $row_discount) {
                            $amount_paid = $amount_paid + $row_discount->amount;
                        }
                        foreach ($amount as $row_amount) {
                            $tamount = $tamount + $row_amount->discounted_price;
                            if ($row_amount->invoice != $invoice) {
                                $specialDiscount_total += $row_amount->specialDiscount;
                                $invoice = $row_amount->invoice;
                            }
                        }
                        echo $tamount - $specialDiscount_total;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $amount_paid;
                        ?>
                    </td>
                    <td>
                        <?php
                        $tamount = $tamount - $specialDiscount_total;
                        echo $tamount = $tamount - $amount_paid;
                        ?>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>

    <div align="center" >
        <?php echo "Total Quantity: " . $total_qty; ?>
        <br><br>
        <?php echo "Total Amount: " . $appliedDiscount; ?>
        <br><br>
        <?php echo "Special Discount: " . $specialDiscount_total; ?>
        <br><br>
        <?php
        if ($discountedPrice != '') {
            echo "Net Amount: " . $discountedPrice;
        } else {
            echo "Net Amount: " . $appliedDiscount;
        }
        ?>
    </div>
</div>