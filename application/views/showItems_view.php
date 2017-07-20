<div align="center" class="main_top">
    <div class="confirm-div" style="font-weight: bold; color: red;">
        <?php
        if ($this->session->flashdata('msg')) {
            ?>
            <?php echo $this->session->flashdata('msg'); ?>
        <?php } ?>
    </div>
    <div class="top-form">
        <form class="form-inline" role="form" action="<?php echo site_url() ?>/addItem/add_item" method="post">
            <div class="form-group form_distance">
                <label for="item_name">Item Name:</label>
                <input type="text" name="item_name" id="item_name" required>
            </div>
            <div class="form-group form_distance">
                <label for="item_price">Item Price:</label>
                <input type="text" name="item_price" id="item_price" required>
                <input type="hidden" name="item_id" id="item_id" value="">
                <input type="hidden" name="record_update" id="record_update" value="insert">
                <?php
                foreach ($user_record as $row) {
                    ?>
                    <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                    <input type="hidden" name="company" value="<?php echo $row->company; ?>">
                <?php } ?>
            </div>
<!--            <div class="form-group form_distance">
                <label for="item_inventory">Item Inventory:</label>
                <input type="text" name="item_inventory" id="item_inventory" required>
            </div>-->
            <div class="form-group form_distance">
                <input id="submit_btn" class="btn btn-success" type="submit" name="submit" value="Add Item">
            </div>
        </form>
    </div>
</div>

<div align="center" style="margin-top: 10px;">
    <?php
    if (isset($record)) {
        ?>
        <div style="width:1000px !important; margin-top: 35px;" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Id</th><th>Item Name</th><th>Price</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->id ?></td>
                            <td><?php echo $row->item_name ?></td>
                            <td><?php echo $row->item_price ?></td>
                            <td class="new-action">
                                <div>
                                    <div style="float:left">
                                        <input class="btn btn-warning btn-space" type="submit" name="item" value="Edit" onclick="edit_item(<?php echo $row->id ?>);">
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
                </tbody>
            </table>
        </div>
        <?php echo isset($links) ? $links : ''; ?>
    <?php } ?>
</div>
<script>
                                    function edit_item(item_id)
                                    {
                                        $.ajax({//create an ajax request to load_page.php
                                            type: "GET",
                                            url: "<?php echo site_url() ?>/addItem/update_item",
                                            data: {item_id: item_id},
                                            success: function(response) {
                                                $('#item_name').val(response[0].item_name);
                                                $('#item_price').val(response[0].item_price);
                                                $('#item_id').val(response[0].id);
                                                $('#record_update').val('update');
                                                $('#submit_btn').val('Update Item');
                                            },
                                            dataType: 'json'
                                        });
                                    }
</script>