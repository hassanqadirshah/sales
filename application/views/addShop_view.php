<div>
    <form action="<?php echo site_url() ?>/addShop/add_shop" method="post">
        <label for="shop_name">Shop Name:</label>
        <input type="text" name="shop_name" required>
        <br><br>
        <label for="discount">Discount:</label>
        <input type="text" name="discount" required>
        <?php foreach ($user_record as $row){ ?>
        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
        <input type="hidden" name="company" value="<?php echo $row->company; ?>">
        <?php } ?>
        <br><br>
        <input class="btn btn-success" type="submit" name="submit" value="Insert Record">
    </form>
</div>