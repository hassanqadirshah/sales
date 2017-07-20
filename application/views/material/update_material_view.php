<div align="center" style="margin-top: 10px;">
    <?php
    if (isset($mat_records))
    {
        ?>
        <div style="width:1000px !important" class="table-responsive">
            <table class="table" border="1" id="my_table">
                <tr>
                    <th>Id</th><th>Name</th><th>Action</th>
                </tr>
                <?php
                foreach ($mat_records as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $row->id ?></td>
                    <form id="updateform" action="<?php echo site_url() ?>/material/update_mat" method="post">
                        <td><input type="text" name="mat_name" value="<?php echo $row->mat_name ?>" required></td>
                        <input type="hidden" name="mat_id" value="<?php echo $row->id ?>">
                    </form>
                    <td class="new-action">
                        <div>
                            <div style="float:left">
                                <input class="btn btn-warning" form="updateform" type="submit" name="item_update" value="Update">
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
            </table>
        </div>
<?php } ?>
</div>