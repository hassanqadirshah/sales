<?php $item_count = 1; ?>
<?php $quantity = 0; ?>
<?php $amount = 0; ?>
<?php $d_amount = 0; ?>
<?php $discount_amount = 0; ?>
<?php $specialDiscount_amount = 0; ?>
<div align="center" class="main_top">
    <form class="form-inline" role="form" action="<?php echo site_url() ?>/item_sales/sales_invoice_edit" method="post">
        <div class="form-group form_distance">
            <label for="invoice">Select Invoice:</label>
            <input type="text" name="invoice" value="<?php echo isset($searchInvoice) ? $searchInvoice : '' ?>">
        </div>
        <div class="form-group form_distance">
            <input type="submit" value="Search" />
        </div>
    </form>
</div>

<div align="center" style="margin-top: 40px;">

    <div style="width:1000px !important" class="table-responsive">
        <form id="myform" action="<?php echo site_url() ?>/item_sales/update_new_record" method="post">
            <table class="table" border="1">
                <tr>
                    <td>
                        <label for="shop">Shop</label>
                    </td>
                    <td>
                        <select id="shop" name="shop" class="shop">
                            <?php
                            foreach ($record as $row_shop) {
                                $shop_select = $row_shop->shop_id;
                            }
                            foreach ($shop_record as $row) {
                                if ($shop_select == $row->id) {
                                    $d_amount = $row->discount;
                                    ?>
                                    <option selected value="<?php echo $row->id; ?>"><?php echo $row->shop_name; ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->shop_name; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <?php
                    if (isset($record)) {
                        foreach ($record as $row) {
                            ?>
                        <tr>
                            <td>
                                <label for="date">Date</label>
                            </td>
                            <td>
                                <input id="datepicker" type="text" name="date" placeholder="yyyy-mm-dd" value="<?php echo $row->sale_date; ?>">
                            </td>
                        </tr>
                        <?php
                        break;
                    }
                }
                ?>
            </table>

            <table class="table" id="addrow" border="1">
                <tr><th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th><th>Action</th></tr>
                <?php
                if (isset($record)) {
                    foreach ($record as $row) {
                        ?>
                        <tr id="row<?php echo $row->id ?>">
                            <td>
                                <select name="item[]" id="i<?php echo $item_count ?>" data-id="<?php echo $item_count ?>" class="item">
                                    <?php
                                    foreach ($item_record as $row_item) {
                                        if ($row->item_id == $row_item->id) {
                                            ?>
                                            <option selected value="<?php echo $row_item->id; ?>"><?php echo $row_item->item_name; ?></option>
                                            <?php
                                            $item_price = $row_item->item_price;
                                            var_dump($item_price);
//                                            echo 'hatsada';
//                                            exit();
                                        } else {
                                            ?>
                                            <option value="<?php echo $row_item->id; ?>"><?php echo $row_item->item_name; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="original_price" id="original_price<?php echo $item_count ?>" value="<?php echo $item_price; ?>"/>
                                <input type="hidden" name="invoice" value="<?php echo $invoice ?>"/>
                            </td>
                            <td class="qty_invoice">
                                <input required type="text" name="qty[]" id="q<?php echo $item_count ?>" data-id="<?php echo $item_count ?>" class="quantity iamclicked" onkeypress="myFunction(event)" value="<?php echo $row->qty; ?>">
                                <?php $quantity += $row->qty; ?> 
                            </td>
                            <td class="price_invoice" id="p<?php echo $item_count ?>">
                                <?php echo $item_price * $row->qty; ?>
                                <?php $amount += $item_price * $row->qty; ?>
                                <?php $discount_amount += $d_amount * $row->qty; ?>
                                <?php $specialDiscount_amount = $row->specialDiscount; ?>
                            </td>
                            <td>
                                <button class="btn btn-danger" type="button" onclick="delete_row('orignal',<?php echo $row->id ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php
                        $item_count++;
                        $row_num = $row->id;
                        ?>
                    <?php } ?>
                <?php } ?>

            </table>
            <input class="btn btn-warning btn_addrow" type="button" value="Add Row" onclick="addrow();">
        </form>
    </div>
    <div class="invoice">
        <b>Your Invoice</b>
        <table><tr><th>Quantity: </th><td><?php echo $quantity ?></td></tr>
            <tr><th>Amount: </th><td><?php echo $amount ?></td></tr>
            <tr><th>Discount: </th><td><?php echo $discount_amount ?></td></tr>
            <tr><th>Special Discount: </th><td><input id="discountPageLoad" type="text" name="special_discount" value="<?php echo $specialDiscount_amount; ?>"></td></tr>
            <tr><th>Total Amount: </th><td><?php echo $amount - $discount_amount - $specialDiscount_amount ?></td></tr>
        </table>
    </div>
    <input type="hidden" name="specialDiscountOrignal" id="specialDiscountOrignal" value="<?php echo $specialDiscount_amount; ?>">
    <input form="myform" class="btn btn-success" type="submit" name="submit" value="Submit">
</div>

<script>

                                    $('.iamclicked').keyup(function() {
                                        var nooo = $(this).attr('data-id');
                                        var oprice = $('#original_price' + nooo).val();
                                        var result = oprice * nooo;
                                        $('#p' + nooo).val(result);
                                    });

                                    function myFunction()
                                    {

                                    }
</script>

<script>
    var id = 100;
    function addrow()
    {
        id++;
        $("#addrow").append('<tr id="row' + id + '"><td><select name="item[]" id="i' + id + '" data-id="' + id + '" class="item"><option value="select">Select</option><?php
                foreach ($item_record as $row) {
                    ?><option value="<?php echo $row->id; ?>"><?php echo $row->item_name; ?></option><?php } ?></select><input type="hidden" name="original_price" id="original_price' + id + '" value=""/></td><td class="qty_invoice"><input required type="text" name="qty[]" id="q' + id + '" data-id="' + id + '" class="quantity"></td><td class="price_invoice" id="p' + id + '"></td><td><button class="btn btn-danger" type="button" onclick="delete_row(' + id + ')">Delete</button></td></tr>');
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
                //$('.quantity').change();
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

    function delete_row(text, row_id)
    {
        if (text == 'orignal')
        {
            $.ajax({//create an ajax request to load_page.php
                type: "GET",
                url: "<?php echo site_url() ?>/item_sales/sale_delete",
                data: {id: row_id},
                success: function(response) {
                    var row = document.getElementById('row' + row_id);
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
    //start work from here
    $(document).on('change', '.shop', function() {
        update_invoice();
    });
    $(document).on('change', '#special-discount', function() {
        update_invoice();
    });
    $(document).on('change', '#discountPageLoad', function() {
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
                //alert(discount_amount);
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
        var tempDiscount = 0;
        var discountPageLoad = 0;
        discountPageLoad = $('#discountPageLoad').val();
        if (isNaN(discountPageLoad))
        {
            tempDiscount = $('#specialDiscountOrignal').val();
            if (tempDiscount != 0)
            {
                $('#specialDiscountOrignal').val(0);
                special_discount = tempDiscount;
            }
            else
            {
                special_discount = $('#special-discount').val();
            }
        }
        else
        {
            special_discount = $('#discountPageLoad').val();
            $('#discountPageLoad').val(special_discount);
        }
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
        //alert(t_quantity);
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
            text += '<tr><th>Special Discount: </th><td><input form="myform" id="special-discount" type="text" name="special_discount" value="' + special_discount + '"></td></tr>';
            text += '<tr><th>Total Amount: </th><td>' + net_amount.toFixed(2) + '</td></tr>';
            text += '</table>';
            $('.invoice').html(text);
            $('#special-discount').val(special_discount);
        }
    }

</script>