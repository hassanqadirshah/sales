<div class="confirm-div" style="font-weight: bold; color: red;">
    <?php if($this->session->flashdata('msg')){ ?>
        <?php echo $this->session->flashdata('msg'); ?>
    <?php } ?>
</div>
<div>
    <form action="<?php echo site_url() ?>/addItem/add_item" method="post">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>
        <br><br>
        <label for="item_price">Item Price:</label>
        <input type="text" name="item_price" required>
        <?php foreach ($user_record as $row){ ?>
        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
        <input type="hidden" name="company" value="<?php echo $row->company; ?>">
        <?php } ?>
        <br><br>
        <input class="btn btn-success" type="submit" name="submit" value="Insert Record">
    </form>
    <form action="<?php echo site_url() ?>/addItem/add_item" method="post">
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>
        <br><br>
        <label for="item_price">Item Price:</label>
        <input type="text" name="item_price" required>
        <?php foreach ($user_record as $row){ ?>
        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
        <input type="hidden" name="company" value="<?php echo $row->company; ?>">
        <?php } ?>
        <br><br>
        <input class="btn btn-success" type="submit" name="submit" value="Insert Record">
    </form>
</div>