<?php $date = date("Y-m-d"); ?>
<div align="center" style="margin-top: 40px;">

    <div style="width:1000px !important" class="table-responsive">
        <form id="myform" action="<?php echo site_url() ?>/material/add_purchase" method="post">
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
                <tr><th>Material</th><th>Buyer name</th><th>Quantity</th><th>Scale</th><th>Price</th><th>Single Piece Price</th><th>Action</th></tr>

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
                    <td class="Buyername">
                        <input required type="text" name="BuyNam[]" id="buy1" data-id="1" >
                    </td>
                    <td class="qty_invoice">
                        <input required type="text" name="qty[]" id="q1" data-id="1" class="quantity">
                    </td>
                    <td class="scale">
                        <input required type="text" name="scale[]" id="Scale1" data-id="1" placeholder="KG">
                    </td>
                    <td class="price_invoice" id="p1">
                        <input type="text" name="price[]" id="price1" data-id="1" class="price">
                    </td>
                    <td class="total_price" id="total_price1">

                    </td>
                    <td>

                    </td>
                </tr>


            </table>
            <input class="btn btn-warning btn_addrow" type="button" value="Add Row" onclick="addrow();">
        </form>
    </div>
    <div class="invoice">

    </div>
    <input form="myform" class="btn btn-success" type="submit" name="submit" value="Submit">
</div>

<script>
                var id = 1;
                function addrow()
                {
                    id++;
                    $("#addrow").append('<tr id="row' + id + '"><td><select name="item[]" id="i' + id + '" data-id="' + id + '" class="item"><option value="select">Select</option><?php
                            foreach ($mat_record as $row)
                            {
                                ?><option value="<?php echo $row->id; ?>"><?php echo $row->mat_name; ?></option><?php } ?></select></td><td class="Buyername"><input required type="text" name="BuyNam[]" id="buy' + id + '" data-id="' + id + '" class="quantity"></td><td class="qty_invoice"><input required type="text" name="qty[]" id="q' + id + '" data-id="' + id + '" class="quantity"></td><td class="scale"><input required type="text" name="scale[]" id="buy' + id + '" data-id="' + id + '" ></td><td class="price_invoice" id="p' + id + '"><input type="text" name="price[]" id="price' + id + '" data-id="' + id + '" class="price"></td><td class="total_price" id="total_price' + id + '"></td><td><button class="btn btn-danger" type="button" onclick="delete_row(' + id + ')">Delete</button></td></tr>');
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
                function delete_row(row_id)
                {
                    var row = document.getElementById('row' + row_id);
                    row.parentNode.removeChild(row);
                    update_invoice();
                }

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