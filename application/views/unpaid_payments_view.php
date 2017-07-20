<?php
$total_unpaid = 0;
?>
<div align="center" class="main_top">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/item_sales/unpaid_filter" method="post">
        <div class="form-group form_distance">
            <label for="shop_name">Shop Name</label>
            <select name="shop_name">
                <option value="">Select</option>
                <?php
                if (isset($record2))
                {
                    ?>
                    <?php
                    foreach ($record2 as $row)
                    {
                        ?>
                        <option value="<?php echo $row->id ?>"><?php echo $row->shop_name ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group form_distance">
            <input type="submit" value="Search" />
        </div>
    </form>
</div>


<div align="center">
    <?php
    if (isset($record))
    {
        ?>
        <div style="width:1300px !important" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Shop Name</th><th>Payment Mode</th><th>Amount</th><th>Comment</th>
                        <th>Date</th><th>Is Received</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row)
                    {
                        ?>
                        <tr>
                            <td>
                                <?php
                                foreach ($this->shop_model->get_shop_record($row->shop_id) as $shop_name)
                                {
                                    echo $shop_name->shop_name;
                                }
                                ?>
                            </td>
                            <td><?php echo $row->payment_mode ?></td>
                            <td><?php echo $row->amount ?></td>
                            <td><?php echo $row->comment ?></td>
                            <td><?php echo $row->date ?></td>
                            <td><?php echo $row->is_received ?></td>
                            <td class="action">
                                    <div style="float: left;">
                                        <form action="<?php echo site_url() ?>/item_sales/edit_unpaid_payments" method="post">
                                            <input type="hidden" name="payment_id" value="<?php echo $row->id ?>">
                                            <input class="btn btn-warning" type="submit" name="item" value="Update">
                                        </form>
                                    </div>
                                    <div style="margin-top: 40px;">
                                        <form action="<?php echo site_url() ?>/item_sales/delete_payment" method="post">
                                            <input type="hidden" name="payment_id" value="<?php echo $row->id ?>">
                                            <input class="btn btn-danger" type="submit" name="item" value="Delete">
                                        </form>
                                    </div>
                            </td>
                        </tr>
                        <?php
                        $total_unpaid += $row->amount;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>
<div align="center" style="font-weight: bold;">
<?php echo "Total Unpaid Amount: " . $total_unpaid; ?>
    <br><br>
</div>