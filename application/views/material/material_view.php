<div align="center" class="main_top">
    <div class="confirm-div" style="font-weight: bold; color: red;">
        <?php
        if ($this->session->flashdata('msg')) {
            ?>
            <?php echo $this->session->flashdata('msg'); ?>
        <?php } ?>
    </div>
    <div>
        <form class="form-inline" role="form" action="<?php echo site_url() ?>/material/insert_material" method="post">
            <div class="form-group form_distance">
                <label for="mat_name">Material Name:</label>
                <input type="text" name="mat_name" id="mat_name" required>
                <input type="hidden" name="mat_id" id="mat_id" value="">
                <input type="hidden" name="record_update" id="record_update" value="insert">
            </div>
            <div class="form-group form_distance">
                <?php
                foreach ($user_record as $row) {
                    ?>
                    <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                    <input type="hidden" name="company" value="<?php echo $row->company; ?>">
                <?php } ?>
                <input id="submit_btn" class="btn btn-success" type="submit" name="submit" value="Insert Material">
            </div>
        </form>
    </div>
</div>

<div align="center" style="margin-top: 10px;">
    <?php
    if (isset($record)) {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Id</th><th>Name</th><th>Qty</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->id ?></td>
                            <td><?php echo $row->mat_name ?></td>
                            <td><?php echo $row->total_qty ?></td>
                            <td class="new-action">
                                <div>
                                    <div style="float:left">
                                        <input class="btn btn-warning btn-space" type="submit" name="mat_item" value="Edit" onclick="edit_mat(<?php echo $row->id ?>);">
                                    </div>
                                    <div style="float: left">
                                        <form action="<?php echo site_url() ?>/material/delete_mat" method="post">
                                            <input type="hidden" name="mat_id" value="<?php echo $row->id ?>">
                                            <input class="btn btn-danger" type="submit" name="mat_item" value="Delete">
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
    <?php } ?>
</div>

<script>
                                        function edit_mat(mat_id)
                                        {
                                            $.ajax({//create an ajax request to load_page.php
                                                type: "GET",
                                                url: "<?php echo site_url() ?>/material/update_mat",
                                                data: {mat_id: mat_id},
                                                success: function(response) {
                                                    $('#mat_name').val(response[0].mat_name);
                                                    $('#mat_id').val(response[0].id);
                                                    $('#record_update').val('update');
                                                    $('#submit_btn').val('Update Material');
                                                },
                                                dataType: 'json'
                                            });
                                        }
</script>