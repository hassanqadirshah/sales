<div class="filter">
    <form action="<?php echo site_url() ?>/item_sales/filter" method="post">
        <table class="simple">
            <tr>
                <td><label for="date">From Date</label></td>
                <td><input id="datepicker" type="text" name="fromdate" placeholder="yyyy-mm-dd"></td>
            </tr>
            <tr>
                <td><label for="date">To Date</label></td>
                <td><input id="datepicker1" type="text" name="todate" placeholder="yyyy-mm-dd"></td>
            </tr>
            <tr>
                <td><label for="shop_name">Shop Name</label></td>
                <td><select name="shop_name">
                        <option value="">Select</option>
                        <?php
                        if (isset($record2))
                        {
                            ?>
                            <?php
                            foreach ($record2 as $row)
                            {
                                ?>
                                <option value="<?php echo $row->shop_name ?>"><?php echo $row->shop_name ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="item_name">Item</label></td>
                <td><select name="item_name">
                        <option value="">Select</option>
                        <?php
                        if (isset($record3))
                        {
                            ?>
                            <?php
                            foreach ($record3 as $row)
                            {
                                ?>
                                <option value="<?php echo $row->item_name ?>"><?php echo $row->item_name ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr><td><input type="submit" value="Search" /></td></tr>
        </table>
    </form>
</div>


<div align="center">
    <?php
    if (isset($record))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <thead>
                <th>Item Name</th><th>Item Price</th><th>Shop Name</th><th>Discount</th>
                <th>Date</th><th>Quantity</th><th>Invoice</th><th>Action</th>
                </thead>
                <?php
                foreach ($record as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->item_name ?></td>
                        <td><?php echo $row->item_price ?></td>
                        <td><?php echo $row->shop_name ?></td>
                        <td><?php echo $row->discount ?></td>
                        <td><?php echo $row->sale_date ?></td>
                        <td><?php echo $row->qty ?></td>
                        <td><?php echo $row->invoice ?></td>
                        <td class="action">
                            <div style="margin-left: 5px;">
                                <div style="float: left;">
                                    <form action="<?php echo site_url() ?>/item_sales/sales_edit" method="post">
                                        <input type="hidden" name="sale_id" value="<?php echo $row->sale_id ?>">
                                        <input class="btn btn-warning" type="submit" name="edit" value="Edit">
                                    </form>
                                </div>
                                <div style="float: right;">
                                    <form action="<?php echo site_url() ?>/item_sales/sale_delete" method="post">
                                        <input type="hidden" name="sale_id" value="<?php echo $row->sale_id ?>">
                                        <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                                    </form>
                                </div>
                            </div>
                        </td>

                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>

    <?php echo isset($links) ? $links : ''; ?>
    <?php
    if (isset($record_filter))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <thead>
                <th>Item Name</th><th>Item Price</th><th>Shop Name</th><th>Discount</th>
                <th>Date</th><th>Quantity</th><th>Action</th>
                </thead>
                <?php
                foreach ($record_filter as $row)
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
                                    <form action="<?php echo site_url() ?>/item_sales/sales_edit" method="post">
                                        <input type="hidden" name="sale_id" value="<?php echo $row->sale_id ?>">
                                        <input type="submit" name="edit" value="Edit">
                                    </form>
                                </div>
                                <div style="float: right;">
                                    <form action="<?php echo site_url() ?>/item_sales/sale_delete" method="post">
                                        <input type="hidden" name="sale_id" value="<?php echo $row->sale_id ?>">
                                        <input type="submit" name="delete" value="Delete">
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</div>