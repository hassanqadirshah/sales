<?php
$total_sale = 0;
$discount_price = 0;
$shop_name = '';
$total_quantity = 0;
$specialDiscount = 0;
$invoice = 0;
?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/report/detail_filter" method="post">
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
                        <option value="<?php echo $row->shop_name ?>"><?php echo $row->shop_name ?></option>
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
    <?php
    if (isset($record)) {
        foreach ($record as $row) {
            ?>
            <h1><?php echo $row->shop_name ?></h1>
            <div style="width:1000px !important" class="table-responsive">
                <table class="table" border="1">
                    <thead>
                        <tr>
                            <th>Item Name</th><th>Item Price</th><th>Discount</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($this->report_model->getshop_data($company, $row->shop_name) as $report_detail) {
                            ?>

                            <tr>
                                <td><?php echo $report_detail->item_name ?></td>
                                <td><?php echo $report_detail->item_price ?></td>
                                <td><?php echo $report_detail->discount ?></td>
                                <td><?php echo $report_detail->qty ?></td>
                                <?php
                                $total_sale += $report_detail->item_price * $report_detail->qty;
                                $discount_price += $report_detail->discounted_price;
                                $total_quantity += $report_detail->qty;
                                if ($report_detail->invoice != $invoice) {
                                    $specialDiscount += $report_detail->specialDiscount;
                                    $invoice = $report_detail->invoice;
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div align="center" >
                <?php echo "Total Sale: " . $total_sale; ?>
                <br><br>
                <?php echo "Special Discount: " . $specialDiscount; ?>
                <br><br>
                <?php echo "Sale After Discount: " . ($discount_price - $specialDiscount); ?>
                <br><br>
                <?php echo "Total Quantity: " . $total_quantity; ?>
            </div>
            <?php
            $total_sale = 0;
            $discount_price = 0;
            $total_quantity = 0;
            ?>
            <?php
        }
    }
    ?>
</div>