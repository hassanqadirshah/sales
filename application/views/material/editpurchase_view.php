<?php $count = 1; ?>
<?php $quantity = 0; ?>
<?php $material_id = 0; ?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/material/material_purchase_edit" method="post">
        <div class="form-group form_distance">
            <label for="invoice">Select Invoice:</label>
            <?php if(isset($invoice)){ ?>
            <input value='<?php echo $invoice ?>' type="text" name="invoice">
            <?php }else{ ?>
            <input type="text" name="invoice">
            <?php } ?>
        </div>
        <div class="form-group form_distance">
            <input type="submit" value="Search" />
        </div>
    </form>
</div>

<div align="center" style="margin-top: 40px;">

    <div style="width:1000px !important" class="table-responsive">
        <form id="myform" action="<?php echo site_url() ?>/material/update_mat_purchase" method="post">
            <table class="table" border="1">
                <?php
                if (isset($record))
                {
                    foreach ($record as $row)
                    {
                        ?>
                        <tr>
                            <td>
                                <label for="date">Date</label>
                            </td>
                            <td>
                                <input id="datepicker" type="text" name="date" placeholder="yyyy-mm-dd" value="<?php echo $row->purchase_date; ?>">
                            </td>
                        </tr>
                        <?php
                        break;
                    }
                }
                ?>
            </table>

            <table class="table" id="addrow" border="1">
                <tr><th>Material</th><th>Quantity</th><th>Price</th><th>Single Piece Price</th><th>Action</th></tr>
                <?php
                if (isset($record))
                {
                    foreach ($record as $row)
                    {
                        ?>
                        <tr id="row<?php echo $row->id ?>">
                            <td>
                                <select name="item[]" id="i<?php echo $count ?>" data-id="<?php echo $count ?>" class="item">
                                    <?php
                                    foreach ($mat_record as $row_mat)
                                    {
                                        if ($row->mat_id == $row_mat->id)
                                        {
                                            ?>
                                            <option selected value="<?php echo $row_mat->id; ?>"><?php echo $row_mat->mat_name; ?></option>
                                            <?php
                                            $material_id = $row_mat->id;
                                        }
                                        else
                                        {
                                            ?>
                                            <option value="<?php echo $row_mat->id; ?>"><?php echo $row_mat->mat_name; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="qty_invoice">
                                <input required type="text" name="qty[]" id="q<?php echo $count ?>" data-id="<?php echo $count ?>" class="quantity" value="<?php echo $row->mat_qty ?>">
                                <?php $quantity = $row->mat_qty; ?>
                            </td>
                            <td class="price_invoice" id="p<?php echo $count ?>">
                                <input type="text" name="price[]" id="price<?php echo $count ?>" data-id="<?php echo $count ?>" class="price" value="<?php echo $row->mat_price ?>">
                                <input type="hidden" name="invoice" value="<?php echo $row->invoice ?>">
                                <input type="hidden" name="material_id[]" value="<?php echo $row->mat_id ?>">
                                <input type="hidden" name="material_qty[]" value="<?php echo $row->mat_qty ?>">
                            </td>
                            <td class="total_price" id="total_price<?php echo $count ?>">
                                <?php echo $row->single_price ?>
                            </td>
                            <td>
                                <button class="btn btn-danger" type="button" onclick="delete_row('orignal',<?php echo $row->id ?>,<?php echo $material_id ?>, <?php echo $quantity ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php
                        $count++;
                        $quantity = 0;
                        ?>
                    <?php } ?>
                <?php } ?>

            </table>
            <input class="btn btn-warning btn_addrow" type="button" value="Add Row" onclick="addrow();">
        </form>
    </div>


    <div class="invoice">

    </div>
    <input form="myform" class="btn btn-success" type="submit" name="submit" value="Submit">
</div>

<script>
                            var id = 100;
                            function addrow()
                            {
                                id++;
                                $("#addrow").append('<tr id="row' + id + '"><td><select name="item[]" id="i' + id + '" data-id="' + id + '" class="item"><option value="select">Select</option><?php
                foreach ($mat_record as $row)
                {
                    ?><option value="<?php echo $row->id; ?>"><?php echo $row->mat_name; ?></option><?php } ?></select></td><td class="qty_invoice"><input required type="text" name="qty[]" id="q' + id + '" data-id="' + id + '" class="quantity"></td><td class="price_invoice" id="p' + id + '"><input type="text" name="price[]" id="price' + id + '" data-id="' + id + '" class="price"></td><td class="total_price" id="total_price' + id + '"></td><td><button class="btn btn-danger" type="button" onclick="delete_row(' + id + ')">Delete</button></td></tr>');
                            }

                            function delete_row(text, mat_id, idd, qty)
                            {
                                if (text == 'orignal')
                                {
                                    $.ajax({//create an ajax request to load_page.php
                                        type: "GET",
                                        url: "<?php echo site_url() ?>/material/mat_delete",
                                        data: {id: mat_id, material_id: idd, quantity: qty},
                                        success: function(response) {
                                            var row = document.getElementById('row' + mat_id);
                                            row.parentNode.removeChild(row);
                                        }
                                    });
                                    update_invoice();
                                }
                                else
                                {
                                    var row = document.getElementById('row' + text);
                                    row.parentNode.removeChild(row);
                                    update_invoice();
                                }
                            }

                            $(document).on('change', '.quantity', function() {
                                var id = $(this).data('id');
                                var quan = parseInt($(this).val());
                                var price = parseFloat($('#price' + id).val());
                                if (!isNaN(price))
                                {
                                    var total_price = price / quan;
                                    $('#total_price' + id).html(total_price);
                                }
                                update_invoice();
                                return false;
                            });
                            $(document).on('change', '.price', function() {
                                var id = $(this).data('id');
                                var price = parseInt($(this).val());
                                var quantity = parseFloat($('#q' + id).val());
                                if (!isNaN(quantity))
                                {
                                    var total_price = price / quantity;
                                    $('#total_price' + id).html(total_price);
                                }
                                update_invoice();
                                return false;
                            });

                            function update_invoice()
                            {
                                var total_amount = 0;
                                var quan = 0;
                                $('.quantity').each(function() {
                                    quan = parseInt(quan) + parseInt($(this).val());
                                });
                                $('.price').each(function() {
                                    total_amount = parseInt(total_amount) + parseInt($(this).val());
                                    if (!isNaN(total_amount))
                                    {
                                        var text = '<b>Your Invoice</b>';
                                        text += '<table><tr><th>Quantity: </th><td>' + quan + '</td></tr>';
                                        text += '<tr><th>Total Amount: </th><td>' + total_amount + '</td></tr>';
                                        text += '</table>';
                                        $('.invoice').html(text);
                                    }
                                });
                            }

</script>