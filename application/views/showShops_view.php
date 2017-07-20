<div align="center" class="main_top">
    <div class="confirm-div" style="font-weight: bold; color: red;">
        <?php
        if ($this->session->flashdata('msg')) {
            ?>
            <?php echo $this->session->flashdata('msg'); ?>
        <?php } ?>
    </div>
    <div class="top-form">
        <form class="form-inline" role="form" action="<?php echo site_url() ?>/addShop/add_shop" method="post">
            <div class="form-group form_distance">
                <label for="shop_name">Customer Name:</label>
                <input type="text" name="shop_name" id="shop_name" required>
            </div>
            <div class="form-group form_distance">
                <label for="discount">Discount:</label>
                <input type="text" name="discount" id="discount" required>
                <input type="hidden" name="shop_id" id="shop_id" value="">
                <input type="hidden" name="record_update" id="record_update" value="insert">
                <?php
                foreach ($user_record as $row) {
                    ?>
                    <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                    <input type="hidden" name="company" value="<?php echo $row->company; ?>">
                <?php } ?>
            </div>
            <div class="form-group form_distance">
                <input id="submit_btn" class="btn btn-success" type="submit" name="submit" value="Insert Shop">
            </div>
        </form>
    </div>
</div>

<div align="center" style="margin-top: 30px;">
    <?php
    if (isset($record)) {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Id</th><th>Customer Name</th><th>Discount</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->id ?></td>
                            <td><?php echo $row->shop_name ?></td>
                            <td><?php echo $row->discount ?></td>
                            <td class="new-action">
                                    <div style="float:left">
                                        <form action="<?php echo site_url() ?>/addShop/shop_detail" method="post">
                                            <input type="hidden" name="shop_id" value="<?php echo $row->id ?>">
                                            <input class="btn btn-success btn-space" type="submit" name="shop" value="Shop Details">
                                        </form>
                                    </div>
                                    <div style="float:left">
                                        <input class="btn btn-warning btn-space" type="submit" name="shop" value="Edit" onclick="edit_shop(<?php echo $row->id ?>);">
                                    </div>
                                    <div style="float:left">
                                        <form action="<?php echo site_url() ?>/addShop/delete_shop" method="post">
                                            <input type="hidden" name="shop_id" value="<?php echo $row->id ?>">
                                            <input class="btn btn-danger" type="submit" name="shop" value="Delete">
                                        </form>
                                    </div>
                                    <br style="clear: left;" />
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php echo isset($links) ? $links : ''; ?>
    <?php } ?>
</div>

<script>
                                    function edit_shop(shop_id)
                                    {
                                        console.log(shop_id);
                                        $.ajax({//create an ajax request to load_page.php
                                            type: "GET",
                                            url: "<?php echo site_url() ?>/addShop/update_shop",
                                            data: {shop_id: shop_id},
                                            success: function(response) {
                                                $('#shop_name').val(response[0].shop_name);
                                                $('#discount').val(response[0].discount);
                                                $('#shop_id').val(response[0].id);
                                                $('#record_update').val('update');
                                                $('#submit_btn').val('Update Shop');
                                            },
                                            dataType: 'json'
                                        });
                                    }
</script>