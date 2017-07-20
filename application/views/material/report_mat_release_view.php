<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/material/filter_release" method="post">
        <div class="form-group form_distance">
            <label for="date">From Date</label>
            <input id="datepicker" type="text" name="fromdate" placeholder="yyyy-mm-dd">
        </div>
        <div class="form-group form_distance">
            <label for="date">To Date</label>
            <input id="datepicker1" type="text" name="todate" placeholder="yyyy-mm-dd">
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
                        <th>Invoice</th><th>Material Name</th><th>Quantity</th><th>Comment</th><th>Release Date</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($record as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->invoice ?></td>
                            <td><?php echo $row->mat_name ?></td>
                            <td><?php echo $row->mat_qty ?></td>
                            <td><?php echo $row->text ?></td>
                            <td><?php echo $row->release_date ?></td>
                            <td class="action">
                                <div style="margin-left: 5px;">
                                    <form action="<?php echo site_url() ?>/material/delete_mat_release" method="post">
                                        <input type="hidden" name="mat_id" value="<?php echo $row->release_id ?>">
                                        <input type="hidden" name="id" value="<?php echo $row->mat_id ?>">
                                        <input type="hidden" name="qty" value="<?php echo $row->mat_qty ?>">
                                        <input class="btn btn-success" type="submit" name="release_report" value="Delete">
                                    </form>
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