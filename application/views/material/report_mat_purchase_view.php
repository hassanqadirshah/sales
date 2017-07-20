<?php
$total_sale = 0;
$total_quantity = 0;
?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/material/filter" method="post">
        <div class="form-group form_distance">
            <label for="date">From Date</label>
            <input id="datepicker" type="text" name="fromdate" placeholder="yyyy-mm-dd">
        </div>
        <div class="form-group form_distance">
            <label for="date">To Date</label>
            <input id="datepicker1" type="text" name="todate" placeholder="yyyy-mm-dd">
        </div>
        <div class="form-group form_distance">
            <label for="date">Name</label>
            <input id="name1" type="text" name="date" placeholder="yyyy-mm-dd">
        </div>
        <div class="form-group form_distance">
            <label for="mat_name">Material Name</label>
            <select name="mat_name">
                <option value="">Select</option>
                <?php
                if (isset($record2))
                {
                    ?>
                    <?php
                    foreach ($record2 as $row)
                    {
                        ?>
                        <option value="<?php echo $row->id ?>"><?php echo $row->mat_name ?></option>
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
        <div style="width:1200px !important; margin-top: 25px;" class="table-responsive">
            <table class="table" border="1" id="my_table_report">
                <thead>
                    <tr>
                        <th>Invoice</th><th>Customer Name</th><th>Material Name</th><th>Price</th><th>Quantity</th><th>Total Price</th>
                        <th>Purchase Date</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->invoice ?></td>
                            <td><?php echo $row->buyer?></td>
                            <td><?php echo $row->mat_name ?></td>
                            <td><?php echo $row->single_price ?></td>
                            <td><?php echo $row->mat_qty ?></td>
                            <td><?php echo $row->mat_price ?></td>
                            <td><?php echo $row->purchase_date ?></td>
                            <td class="action">
                                <div style="margin-left: 5px;">
                                    <form action="<?php echo site_url() ?>/material/delete_mat_purchase" method="post">
                                        <input type="hidden" name="mat_id" value="<?php echo $row->purchase_id ?>">
                                        <input type="hidden" name="id" value="<?php echo $row->mat_id ?>">
                                        <input type="hidden" name="qty" value="<?php echo $row->mat_qty ?>">
                                        <input class="btn btn-success" type="submit" name="purchase_report" value="Delete">
                                    </form>
                                </div>
                            </td>
                            <?php
                            $total_sale = $total_sale + $row->mat_price;
                            $total_quantity = $total_quantity + $row->mat_qty;
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
    <div align="center" >
        <?php echo "Total Price: " . $total_sale; ?>
        <br><br>
        <?php echo "Total Quantity: " . $total_quantity; ?>
    </div>
</div>