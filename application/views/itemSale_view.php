<?php $date = date("Y-m-d"); ?>
<div align="center" style="margin-top: 40px;">

    <div style="width:1000px !important" class="table-responsive">
        <form id="myform" action="<?php echo site_url() ?>/item_sales/addrecord" method="post">
            <table class="table" border="1">

                <tr>
                    <td>
                        <label for="invoice">Invoice</label>
                    </td>
                <div style="float: right; margin-right: 15px">
                    <h1>AS Traders </h1>
                    <i>0423-6860723</i> <br>
                    <i>0300-9443803</i> <br>
                    <i>0300-4908185</i> <br>
                </div>
                <div style="float: left; margin-left: 15px">;
                    <h3>Shop # 10 Shah Kamal Road,<br> Majjan Wala Adda <br> Mughal Pura Lahore </h3>

                </div>

                <div style="width: 100%; height: 2px; background-color: grey;"></div>;
                <div style="width: 100%; height: 2px; background-color: grey; margin-top: 142px"></div>;

                <td>
                    <input type="text" name="invoice" value="<?php echo $high_invoice ?>" required>
                </td>
                </tr>
                <tr>
                    <td>
                        <label for="shop">Customer</label>
                    </td>
                    <td>
                        <select id="shop" name="shop" class="shop">
                            <?php
                            foreach ($shop_record as $row) {
                                ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->shop_name; ?></option>
                            <?php } ?>
                        </select>
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
                <tr><th>Item</th><th>Quantity</th><th>Price</th><th>Action</th></tr>

                <tr>
                    <td>
                        <select name="item[]" id="i1" data-id="1" class="item">
                            <option value="select">Select</option>
                            <?php
                            foreach ($item_record as $row) {
                                ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->item_name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="qty_invoice">
                        <input required type="text" name="qty[]" id="q1" data-id="1" class="quantity">
                    </td>
                    <td class="price_invoice" id="p1">

                    </td>
                    <td>
                        <input type="hidden" name="original_price" id="original_price1" value=""/>

                    </td>
                </tr>


            </table>
            <input class="btn btn-warning btn_addrow" type="button" value="Add Row" onclick="addrow();">

            <div style="float: left; margin-left: 15px;">;
                <p>Sign</p>
                <p>_______________________</p>

            </div>
            <div style="float: left; margin-left: 50px;">
                <p>Stamp</p>
                <p style="margin-top: 50px">_______________________</p>

            </div>
        </form>
    </div>
    <div class="invoice">

    </div>
    <input form="myform" class="btn btn-success" type="submit" name="submit" value="Submit" onclick="myFunction()" id="haris">
    <input  class="btn btn-success" onclick="myFunction()" value="Print Invoice">




    <script>
                function myFunction() {
                    window.print();
                    $(".delete").css('display', 'none');
                    $(".btn-success").css('display', 'none');

                }
    </script>
</div>

<script>
    var id = 1;
    function addrow()
    {
        id++;
        $("#addrow").append('<tr id="row' + id + '"><td><select name="item[]" id="i' + id + '" data-id="' + id + '" class="item"><option value="select">Select</option><?php
                            foreach ($item_record as $row) {
                                ?><option value="<?php echo $row->id; ?>"><?php echo $row->item_name; ?></option><?php } ?></select></td><td class="qty_invoice"><input required type="text" name="qty[]" id="q' + id + '" data-id="' + id + '" class="quantity"></td><td class="price_invoice" id="p' + id + '"></td><td><button class="btn btn-danger" class = "delete" type="button" onclick="delete_row(' + id + ')">Delete</button><input type="hidden" name="original_price" id="original_price' + id + '" value=""/></td></tr>');
        update_invoice();
    }

    $(document).on('change', '.item', function() {
        var id = $(this).data('id');

        var val = $(this).val();
        var element = $(this).attr('id');
        var sel = document.getElementById(element);
        var value = sel.options[sel.selectedIndex].value;
        // record retrive
        $.ajax({//create an ajax request to load_page.php
            type: "GET",
            url: "<?php echo site_url() ?>/item_sales/fetch_item_record",
            data: {item_id: value},
            success: function(response) {
                $('#original_price' + id).val(response);
                //alert($('#original_price' + id).val());
                var op = parseFloat($('#original_price' + id).val());
                var quan = parseFloat($('#q' + id).val());
                var price = quan * op;
                if (isNaN(price))
                {
                    price = 0;
                }
                $('#p' + id).html(price);
                $('#q' + id).change();
                update_invoice();
            }
        });

        return false;
    });

    $(document).on('change', '.quantity', function() {
        var id = $(this).data('id');
        var quan = parseFloat($(this).val());
        var op = parseFloat($('#original_price' + id).val());
        var price = quan * op;

        if (isNaN(price))
        {
            price = 0;
        }
        $('#p' + id).html(price.toFixed(2));
        update_invoice();
        // record retrive

        // $('#original_price'+id).val();

        return false;
    });
    $(document).ready(function() {
        var id = 2;
    });
    function delete_row(row_id)
    {
        var row = document.getElementById('row' + row_id);
        row.parentNode.removeChild(row);
        update_invoice();
    }
    $(document).on('change', '.shop', function() {
        update_invoice();
    });
    $(document).on('change', '#special-discount', function() {
        update_invoice();
    });
    function update_invoice()
    {
        var discount_amount = 0;
        var sel = document.getElementById('shop');
        var shop_id = sel.options[sel.selectedIndex].value;
        //alert(shop_id);
        $.ajax({//get shop discount
            type: "GET",
            url: "<?php echo site_url() ?>/item_sales/fetch_shop_discount",
            data: {shop_id: shop_id},
            success: function(response) {
                discount_amount = response;
                display_record(discount_amount);
            }
        });
    }

    function display_record(discount_amount)
    {
        var quantity = 0;
        var t_quantity = 0;
        var total_amount = 0;
        var cal_amount = 0;
        var p_found = 0;
        var q_found = 0;
        var special_discount = 0;
        special_discount = $('#special-discount').val();
        if (isNaN(special_discount))
        {
            special_discount = 0;
        }
        $(".qty_invoice input").each(function()
        {
            var id = $(this).attr("id");
            quantity = document.getElementById(id).value;
            if (quantity != '')
            {
                q_found = 1;
                t_quantity = parseFloat(t_quantity) + parseFloat(quantity);
            }
            else
            {
                if (q_found == 0)
                {
                    t_quantity = 0;
                }
            }

        });
        if (discount_amount == 0)
        {
            $(".price_invoice").each(function() {
                cal_amount = $(this).html();
                if (cal_amount != '')
                {
                    p_found = 1;
                    total_amount = parseFloat(total_amount) + parseFloat(cal_amount);
                }
                else
                {
                    if (p_found == 0)
                    {
                        total_amount = 0;
                    }
                }

            });
        }
        else
        {
            discount_amount = t_quantity * discount_amount;
            $(".price_invoice").each(function() {
                cal_amount = $(this).html();
                total_amount = parseFloat(total_amount) + parseFloat(cal_amount);
            });
        }
        if (!isNaN(total_amount))
        {
            var net_amount = total_amount - discount_amount - special_discount;
            var text = '<b>Your Invoice</b>';
            text += '<table><tr><th>Quantity: </th><td>' + t_quantity.toFixed(1) + '</td></tr>';
            text += '<tr><th>Amount: </th><td>' + total_amount.toFixed(2) + '</td></tr>';
            text += '<tr><th>Discount: </th><td>' + discount_amount.toFixed(2) + '</td></tr>';
            text += '<tr><th>Special Discount: </th><td><input form="myform" id="special-discount" type="text" name="special_discount"></td></tr>';
            text += '<tr><th>Total Amount: </th><td>' + net_amount.toFixed(2) + '</td></tr>';
            text += '</table>';
            $('.invoice').html(text);
            $('#special-discount').val(special_discount);
        }
    }

</script>                               