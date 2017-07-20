<?php $count = 1; ?>
<?php $quantity = 0; ?>
<?php $material_id = 0; ?>
<div align="center">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/material/material_release_edit" method="post">
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
    <?php
    if ($this->session->flashdata('error_message'))
    {
        echo '<span style="color:red;font-weight:bold">' . $this->session->flashdata('error_message') . '</span>';
    }
    ?>
    <div style="width:1000px !important" class="table-responsive">
        <form id="myform" action="<?php echo site_url() ?>/material/update_mat_release" method="post">
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
                                <input id="datepicker" type="text" name="date" placeholder="yyyy-mm-dd" value="<?php echo $row->release_date; ?>">
                            </td>
                        </tr>
                        <?php
                        break;
                    }
                }
                ?>
            </table>

            <table class="table" id="addrow" border="1">
                <tr><th>Material</th><th>Quantity</th><th>Comment</th><th>Action</th></tr>
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
                                            $quantity = $row_mat->total_qty;
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
                                <input type="hidden" name="invoice" value="<?php echo $row->invoice ?>">
                            </td>
                            <td class="qty_invoice">
                                <input required type="text" name="qty[]" id="q<?php echo $count ?>" data-id="<?php echo $count ?>" class="quantity" value="<?php echo $row->mat_qty ?>">
                                <input type="hidden" name="total_qty" id="total_qty<?php echo $count ?>" value="">
                                
                                <input type="hidden" name="original_total_qty[]" id="original_total_qty<?php echo $count ?>" value="<?php echo $row->mat_qty ?>">
                                <input type="hidden" name="material_id[]" value="<?php echo $row->mat_id ?>">
                                <input type="hidden" name="original_qty[]" id="original_qty<?php echo $count ?>" value="<?php echo $row->mat_qty ?>">
                                <input type="hidden" name="remaining_qty" id="qty_remaining<?php echo $count ?>" value="<?php echo $quantity ?>">
                                
                            </td>
                            <td>
                                <input required type="text" name="text[]" id="txxt<?php echo $count ?>" data-id="<?php echo $count ?>" class="" value="<?php echo $row->text ?>">
                            </td>
                            <td>
                                <button class="btn btn-danger" type="button" onclick="delete_row('orignal',<?php echo $row->id ?>,<?php echo $material_id ?>, <?php echo $row->mat_qty ?>)">Delete</button>
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
    <input form="myform" id="btn_submit" class="btn btn-success" type="submit" name="submit" value="Submit">
</div>

<script>
                            var id = 1000;
                            function addrow()
                            {
                                id++;
                                $("#addrow").append('<tr id="row' + id + '"><td><select name="item[]" id="i' + id + '" data-id="' + id + '" class="item"><option value="select">Select</option><?php
                foreach ($mat_record as $row)
                {
                    ?><option value="<?php echo $row->id; ?>"><?php echo $row->mat_name; ?></option><?php } ?></select></td><td class="qty_invoice"><input required type="text" name="qty[]" id="q' + id + '" data-id="' + id + '" class="quantity"><input type="hidden" name="total_qty" id="total_qty' + id + '" value=""><input type="hidden" name="original_total_qty[]" id="original_total_qty' + id + '" value="0"><input type="hidden" name="remaining_qty" id="qty_remaining' + id + '" value=""></td><td><button class="btn btn-danger" type="button" onclick="delete_row(' + id + ')">Delete</button></td><td><input required type="text" name="text[]" id="txxt' + id + '" data-id="' + id + '" class=""></td></tr>');
                            }

                            function delete_row(text, mat_id, idd, qty)
                            {
                                if (text == 'orignal')
                                {
                                    $.ajax({//create an ajax request to load_page.php
                                        type: "GET",
                                        url: "<?php echo site_url() ?>/material/mat_delete_release",
                                        data: {id: mat_id, material_id: idd, quantity: qty},
                                        success: function(response) {
                                            var row = document.getElementById('row' + mat_id);
                                            row.parentNode.removeChild(row);
                                        }
                                    });
                                }
                                else
                                {
                                    var row = document.getElementById('row' + text);
                                    if ($('#q' + text).hasClass('errorClass'))
                                    {
                                        $("#q" + text).removeClass("errorClass");
                                        $('.quantity').each(function() {
                                            if (!$('input').hasClass('errorClass'))
                                            {
                                                $("#btn_submit").attr("disabled", false);
                                            }
                                        });
                                    }
                                    row.parentNode.removeChild(row);
                                }
                            }

                            $(document).on('change', '.item', function() {
                                var id = $(this).data('id');
                                var mat_id = this.value;
                                $.ajax({//create an ajax request to load_page.php
                                    type: "GET",
                                    url: "<?php echo site_url() ?>/material/fetch_mat_quantity",
                                    data: {mat_id: mat_id},
                                    success: function(response) {
                                        $("#total_qty" + id).val(response);
                                        $("#qty_remaining" + id).val(response);
                                    }
                                });
                                setTimeout(function() {
                                    check_complete_qty(mat_id, id);
                                }, 500);
                            });
                            $(document).on('change', '.quantity', function() {
                                var id = $(this).data('id');
                                var mat_id = $("#i" + id).val();
                                check_complete_qty(mat_id, id);
                                return false;
                            });

                            function check_complete_qty(mat_id, row_id)
                            {
                                var total_quan = 0;
                                var id = 0;
                                var original_qty = 0;
                                var check_qty = 0;
                                $('.quantity').each(function() {
                                    id = $(this).data('id');
                                    var check_mat_qty = $("#i" + id).val();
                                    var quantity = 0;
                                    quantity = parseInt($(this).val());

                                    if (!isNaN(quantity))
                                    {
                                        if (mat_id == check_mat_qty)
                                        {
                                            total_quan += parseInt($(this).val());
                                            original_qty += parseInt($("#original_total_qty" + id).val())
                                        }
                                    }
                                });
                                check_qty = total_quan - original_qty;
                                console.log(check_qty + '-' + parseInt($("#original_total_qty" + row_id).val()));
                                if (check_qty > parseInt($("#qty_remaining" + row_id).val()))
                                {
                                    alert('You dont have enough quantity! Remaining quantity of this item is ' + parseInt($("#qty_remaining" + row_id).val()));
                                    $("#q" + id).addClass('errorClass');
                                    $("#btn_submit").attr("disabled", true);
                                }
                                else
                                {
                                    $("#q" + id).removeClass("errorClass");
                                    $("#btn_submit").attr("disabled", false);
                                }
                                console.log('Total Quantity is ' + total_quan);
                                console.log('Original Quantity is ' + original_qty);
                            }
</script>