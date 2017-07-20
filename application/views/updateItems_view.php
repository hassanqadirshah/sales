<div align="center" style="margin-top: 10px;">
    <?php
    if (isset($item_records))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <th>Id</th><th>Item Name</th><th>Price</th><th>Action</th>
                </tr>
                <?php
                foreach ($item_records as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->id ?></td>
                    <form id="updateform" action="<?php echo site_url() ?>/addItem/update_item" method="post">
                        <td><input type="text" name="item_name" value="<?php echo $row->item_name ?>" required></td>
                        <td><input type="text" name="item_price" value="<?php echo $row->item_price ?>" required></td>
                        <td><input type="text" name="item_price" value="<?php echo $row->item_price ?>" required></td>
                        <input type="hidden" name="item_id" value="<?php echo $row->id ?>">
                    </form>
                    <td class="new-action">
                        <div>
                            <div style="float:left">
                                <input class="btn btn-warning" form="updateform" type="submit" name="item_update" value="Update">
                            </div>
                            <div style="float: left">
                                <form action="<?php echo site_url() ?>/addItem/delete_item" method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $row->id ?>">
                                    <input class="btn btn-danger" type="submit" name="item" value="Delete">
                                </form>
                            </div>
                            <br style="clear: left;" />
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