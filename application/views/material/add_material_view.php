<div class="confirm-div" style="font-weight: bold; color: red;">
    <?php if($this->session->flashdata('msg')){ ?>
        <?php echo $this->session->flashdata('msg'); ?>
    <?php } ?>
</div>
<div>
    <form action="<?php echo site_url() ?>/material/insert_material" method="post">
        <label for="mat_name">Material Name:</label>
        <input type="text" name="mat_name" required>
        <?php foreach ($user_record as $row){ ?>
        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
        <input type="hidden" name="company" value="<?php echo $row->company; ?>">
        <?php } ?>
        <br><br>
        <input class="btn btn-success" type="submit" name="submit" value="Insert Record">
    </form>
</div>