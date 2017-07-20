<?php $unpaid_amount = 0; ?>
<div align="center">
    <?php
    if (isset($payment))
    {
        ?>
        <h1>Report of Overdue Checks</h1>
        <div style="width: 1000px; margin-top: 50px;">
            <table class="table" border="1" id="my_table_report">
                <thead>
                <th>Shop</th><th>Payment Mode</th><th>Amount</th><th>Date of Entry</th><th>Comment</th>
                <th>Is Received</th><th>Overdue Date</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($payment as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->shop_name ?></td>
                            <td><?php echo $row->payment_mode ?></td>
                            <td><?php echo $row->amount ?></td>
                            <td><?php echo $row->date ?></td>
                            <td><?php echo $row->comment ?></td>
                            <td><?php echo $row->is_received ?></td>
                            <td><?php echo $row->overdue_date ?></td>
                        </tr>
                        <?php
                        $unpaid_amount = $unpaid_amount + $row->amount;
                    }
                    ?>
                </tbody>
            </table>

            <div style="font-weight: bold;">
                Total Unpaid Amount <?php echo $unpaid_amount; ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>