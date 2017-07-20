<?php $date = date("Y-m-d"); ?>
<div align="center" style="margin-top: 40px;">

    <div style="width:1000px !important" class="table-responsive">
        <form id="myform" action="<?php echo site_url() ?>/material/release_purchase" method="post">
            <table class="table" border="1">
                <tr>
                    <td>
                        <label for="invoice">Invoice</label>
                    </td>
                    <td>
                        <input type="text" name="invoice" value="<?php echo $high_invoice ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="date">Date</label>
                    </td>
                    <td>
                        <input id="datepicker" type="text" name="date" placeholder="yyyy-mm-dd" value="<?php echo $date ?>">
                    </td>
                </tr>
            </table>

            <table class="table" id="addrow" border="1">
                <tr><th>Material</th><th>Quantity</th><th>Comment</th><th>Action</th></tr>

                <tr>
                    <td>
                        <select name="item[]" id="i1" data-id="1" class="item">
                            <option value="select">Select</option>
                            <?php
                            foreach ($mat_record as $row)
                            {
                                ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->mat_name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="qty_invoice">
                        <input required type="text" name="qty[]" id="q1" data-id="1" class="quantity">
                        <input required type="hidden" name="total_qty" id="total_qty1" value="">
                    </td>
                    <td>
                        <input required type="text" name="text[]" id="txt1" data-id="1" >
                    </td>
                </tr>


            </table>
            <input id="btn_row" class="btn btn-warning btn_addrow" type="button" value="Add Row" onclick="addrow();">
        </form>
    </div>
    <div class="invoice">

    </div>
    <input form="myform" id="btn_submit" class="btn btn-success" type="submit" name="submit" value="Submit">
</div>

<script>
                var id = 1;
                var error_flag = 0;
                function addrow()
                {
                    id++;
                    $("#addrow").append('<tr id="row' + id + '"><td><select name="item[]" id="i' + id + '" data-id="' + id + '" class="item"><option value="select">Select</option><?php
                            foreach ($mat_record as $row)
                            {
                                ?><option value="<?php echo $row->id; ?>"><?php echo $row->mat_name; ?></option><?php } ?></select></td><td class="qty_invoice"><input required type="text" name="qty[]" id="q' + id + '" data-id="' + id + '" class="quantity"><input type="hidden" name="total_qty" id="total_qty' + id + '" value=""></td>  <td class="qty_invoice"><input required type="text" name="text[]" txt="q' + id + '" data-id="' + id + '" class=""></td>   <td><button class="btn btn-danger" type="button" onclick="delete_row(' + id + ')">Delete</button></td></tr>');
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
                        }
                    });
                    check_complete_qty(mat_id);
//                    var quan = $("#q" + id).val();
//                    setTimeout(function() {
//                        check_quantity(quan, id);
//                    }, 500);
                });

                function check_complete_qty(mat_id)
                {
                    var total_quan = 0;
                    var id = 0;
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
                            }
                        }
                    });
                    setTimeout(function() {
                        check_quantity(total_quan, id);
                    }, 500);
                }

                $(document).on('change', '.quantity', function() {
                    var id = $(this).data('id');
                    var quan = parseInt($(this).val());
//                    check_quantity(quan, id);
                    var mat_id = $("#i" + id).val();
                    check_complete_qty(mat_id);
                    return false;
                });
                function delete_row(row_id)
                {
                    var row = document.getElementById('row' + row_id);
                    row.parentNode.removeChild(row);
                    if (!$('input').hasClass('errorClass'))
                    {
                        $("#btn_submit").attr("disabled", false);
                    }
                }
                function check_quantity(quan, id)
                {
                    var original_qty = $("#total_qty" + id).val();
                    if (original_qty != '')
                    {
                        var check = original_qty - quan;
                        if (check < 0)
                        {
                            alert('You dont have enough quantity');
                            $("#q" + id).addClass('errorClass');
                            $("#btn_submit").attr("disabled", true);
//                            $("#btn_row").attr("disabled", true);
                        }
                        else
                        {
//                            if (!$('input').hasClass('errorClass'))
//                            {
//                                $("#btn_submit").attr("disabled", false);
//                            }
//                            $("#btn_row").attr("disabled", false);
                            $("#q" + id).removeClass("errorClass");
                            $("#btn_submit").attr("disabled", false);
                        }
                    }
                }
</script>