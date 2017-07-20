<?php
$total_sale = 0;
$discount_price = 0;
$total_quantity = 0;
$specialDiscount = 0;
$invoice = 0;
?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/report/filter" method="post">
        <div class="form-group form_distance">
            <label for="date">From Date</label>
            <input id="datepicker" type="text" name="fromdate" placeholder="yyyy-mm-dd" value="<?php echo isset($fromDate) ? $fromDate : ''; ?>">
        </div>
        <div class="form-group form_distance">
            <label for="date">To Date</label>
            <input id="datepicker1" type="text" name="todate" placeholder="yyyy-mm-dd" value="<?php echo isset($toDate) ? $toDate : ''; ?>">
        </div>
        <div class="form-group form_distance">
            <label for="shop_name">Customer Name</label>
            <select name="shop_name">
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
            <label for="item_name">Item</label>
            <select name="item_name">
                <option value="">Select</option>
                <?php
                if (isset($record3))
                {
                    ?>
                    <?php
                    foreach ($record3 as $row)
                    {
                        ?>
                        <option <?php echo isset($item_name) ? ($item_name==$row->item_name ? 'selected="selected"' : '') : ''; ?> value="<?php echo $row->item_name ?>"><?php echo $row->item_name ?></option>
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


<div align="center">
    <?php
    if (isset($record))
    {
        ?>
        <div style="width:1400px !important; margin-top: 25px;" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Invoice</th><th>Item Name</th><th>Item Price</th><th>C Name</th><th>Discount</th>
                        <th>Date</th><th>Quantity</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->invoice ?></td>
                            <td><?php echo $row->item_name ?></td>
                            <td><?php echo $row->item_price ?></td>
                            <td><?php echo $row->shop_name ?></td>
                            <td><?php echo $row->discount ?></td>
                            <td><?php echo $row->sale_date ?></td>
                            <td><?php echo $row->qty ?></td>
                            <td class="action">
                                    <div style="float: left;">
                                        <form action="<?php echo site_url() ?>/sales/item_detail" method="post">
                                            <input type="hidden" name="item_id" value="<?php echo $row->item_id ?>">
                                            <input class="btn btn-success" type="submit" name="item" value="Item Details">
                                        </form>
                                    </div>
                                    <div style="margin-top: 40px;">
                                        <form action="<?php echo site_url() ?>/addShop/shop_detail" method="post">
                                            <input type="hidden" name="shop_id" value="<?php echo $row->shop_id ?>">
                                            <input class="btn btn-success" type="submit" name="item" value="Shop Details">
                                        </form>
                                    </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
    <?php
    if (isset($record4))
    {
        foreach ($record4 as $row)
        {
            $total_sale += $row->item_price * $row->qty;
            $discount_price += $row->discounted_price;
            $total_quantity += $row->qty;
            if($row->invoice != $invoice)
            {
                $specialDiscount += $row->specialDiscount;
                $invoice = $row->invoice;
            }
            
        }
    }
    ?>
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