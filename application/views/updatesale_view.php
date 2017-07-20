<div align="center" style="margin-top: 50px;">
    <fieldset class="sale_fieldset">
        <legend>Present Record</legend>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <th>Item Name</th><th>Item Price</th><th>Shop Name</th>
                    <th>Date</th><th>Quantity</th>
                </tr>
                <?php
                foreach ($record as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->item_name; ?></td>
                        <td><?php echo $row->item_price ?></td>
                        <td><?php echo $row->shop_name; ?></td>
                        <td><?php echo $row->sale_date; ?></td>
                        <td><?php echo $row->qty ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </fieldset>



    <?php
    if (isset($record))
    {
        ?>
        <fieldset class="sale_fieldset">
            <legend>New Record</legend>
            <form action="<?php echo site_url() ?>/item_sales/sales_update" method="post">
                <div style="width:1000px !important" class="table-responsive">
                    <table class="table" border="1" id="my_table">
                        <tr>
                            <th>Item Name</th><th>Shop Name</th>
                            <th>Date</th><th>Quantity</th><th>Action</th>
                        </tr>
                        <?php
                        foreach ($record as $row)
                        {
                            ?>
                            <tr>
                                <td>
                                    <select name="item" id="i1" data-id="1" class="item">
                                        <?php
                                        foreach ($item_record as $rowi)
                                        {
                                            ?>
                                            <option value="<?php echo $rowi->id; ?>"><?php echo $rowi->item_name; ?></option>
        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="shop">
                                        <?php
                                        foreach ($shop_record as $rows)
                                        {
                                            ?>
                                            <option value="<?php echo $rows->id; ?>"><?php echo $rows->shop_name; ?></option>
        <?php } ?>
                                    </select>
                                </td>

                                <td>
                                    <input id="datepicker" value="<?php echo $row->sale_date; ?>" type="text" name="date" placeholder="yyyy-mm-dd">
                                </td>

                                <td><input type="text" name="qty" value="<?php echo $row->qty ?>"></td>

                                <td class="action">
                                    <div style="margin-left: 5px;">
        <!--                                    <input type="hidden" name="item_id" value="<?php echo $row->item_id ?>">
                                        <input type="hidden" name="shop_id" value="<?php echo $row->shop_id ?>">-->
                                        <input type="hidden" name="sale_id" value="<?php echo $row->sale_id ?>">
                                        <input class="btn btn-warning" type="submit" name="update" value="Update">
                                    </div>
                                </td>
                            </tr>
    <?php } ?>
                    </table>
                </div>
            </form>
            <span class='sale_span'>Note:- Leave this page if you don't want to update this record!</span>
        </fieldset>
<?php } ?>
</div>