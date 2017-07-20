<div align="center" style="margin-top: 40px;">
    <?php if (isset($records))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <td>Item Id</td><td>Shop Id</td><td>Date</td><td>Quantity</td><td>Action</td>
                </tr>
                <?php
                foreach ($records as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->item_id ?></td>
                        <td><?php echo $row->shop_id ?></td>
                        <td><?php echo $row->sale_date ?></td>
                        <td><?php echo $row->qty ?></td>
                        <td class="action">
                            <div style="margin-left: 5px;">
                                <div style="float: left;">
                                    <form action="<?php echo site_url() ?>/sales/item_detail" method="post">
                                        <input type="hidden" name="item_id" value="<?php echo $row->item_id ?>">
                                        <input type="submit" name="item" value="Item Details">
                                    </form>
                                </div>
                                <div style="float: right;">
                                    <form action="<?php echo site_url() ?>/sales/shop_detail" method="post">
                                        <input type="hidden" name="shop_id" value="<?php echo $row->shop_id ?>">
                                        <input type="submit" name="item" value="Shop Details">
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
<?php } ?>



    <?php if (isset($item_records))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <th>Id</th><th>Item Name</th><th>Price</th>
                </tr>
                <?php
                foreach ($item_records as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->id ?></td>
                        <td><?php echo $row->item_name ?></td>
                        <td><?php echo $row->item_price ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    <?php } ?>


<?php if (isset($shop_records))
{
    ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <td>Id</td><td>Shop Name</td><td>Discount</td><td>Item Name</td><td>Item Price</td>
                    <td>Quantity</td><td>Date</td><td>Action</td>
                </tr>
                <?php
                foreach ($shop_records as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->shop_id ?></td>
                        <td><?php echo $row->shop_name ?></td>
                        <td><?php echo $row->discount ?></td>
                        <td><?php echo $row->item_name ?></td>
                        <td><?php echo $row->item_price ?></td>
                        <td><?php echo $row->qty ?></td>
                        <td><?php echo $row->sale_date ?></td>
                        <td class="action">
                            <div>
                                <form action="<?php echo site_url() ?>/sales/shop_detail" method="post">
                                    <input type="hidden" name="shop_id" value="<?php echo $row->shop_id ?>">
                                    <input type="submit" name="item" value="Shop Details">
                                </form>
                            </div>
                        </td>
                    </tr>
        <?php
    }
    ?>
            </table>
        </div>
<?php } ?>
</div>