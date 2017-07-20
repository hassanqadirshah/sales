<div align="center" style="margin-top: 10px;">
    <?php
    if (isset($shop_records))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <th>Id</th><th>Shop Name</th><th>Discount</th><th>Action</th>
                </tr>
                <?php
                foreach ($shop_records as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->id ?></td>
                    <form id="updateform" action="<?php echo site_url() ?>/addShop/update_shop" method="post">
                        <td><input type="text" name="shop_name" value="<?php echo $row->shop_name ?>" required></td>
                        <td><input type="text" name="discount" value="<?php echo $row->discount ?>" required></td>
                        <input type="hidden" name="shop_id" value="<?php echo $row->id ?>">
                    </form>
                    <td class="new-action">
                        <div>
                            <div style="float:left">
                                <input class="btn btn-warning" form="updateform" type="submit" name="shop_update" value="Update">
                            </div>
                            <div style="float: left">
                                <form action="<?php echo site_url() ?>/addShop/delete_shop" method="post">
                                    <input type="hidden" name="shop_id" value="<?php echo $row->id ?>">
                                    <input class="btn btn-danger" type="submit" name="shop" value="Delete">
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