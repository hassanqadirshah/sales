<?php $total_sale = 0; ?>
<div align="center" style="margin-top: 50px;">
    <?php
    if (isset($shopDetail_records))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <th>Item Name</th><th>Item Price</th><th>Shop Name</th><th>Discount</th>
                    <th>Date</th><th>Quantity</th><th>Action</th>
                </tr>
                <?php
                foreach ($shopDetail_records as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->item_name ?></td>
                        <td><?php echo $row->item_price ?></td>
                        <td><?php echo $row->shop_name ?></td>
                        <td><?php echo $row->discount ?></td>
                        <td><?php echo $row->sale_date ?></td>
                        <td><?php echo $row->qty ?></td>
                        <td class="action">
                            <div style="margin-left: 5px;">
                                <div style="float: left;">
                                    <form action="<?php echo site_url() ?>/sales/item_detail" method="post">
                                        <input type="hidden" name="item_id" value="<?php echo $row->item_id ?>">
                                        <input class="btn btn-success" type="submit" name="item" value="Item Details">
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $total_sale += $row->item_price * $row->qty;
                }
                ?>
            </table>
        </div>
    <?php } ?>
</div>
<div align="center" >
    <?php echo "Total Sale: " . $total_sale; ?>
</div>