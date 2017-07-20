<!DOCTYPE html>
<html>
    <head>
        <title>Items Sales Details</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/css/style.css"   />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/css/styles.css"   />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

        <script>
            $(function() {
                //                $("#datepicker").datepicker();
                $("#datepicker").datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });
        </script>
        <script src="<?php echo base_url() ?>/js/script.js"></script>
        <script src="<?php echo base_url() ?>/js/my_js.js"></script>
    </head>
    <body style="background-color: white;">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<div class="signup">
<div class="testbox">
  <h1>Registration</h1>

  <form action="<?php echo site_url() ?>/login/signup_validation" method="post">
      <hr>
  <label id="icon" for="email"><i class="icon-envelope "></i></label>
  <?php if($record != null) { foreach ($record as $row){ ?>
  <input type="text" name="email" id="name" placeholder="Email" readonly value="<?php echo $row->email ?>"/>
  <?php } } else { ?>
  <input type="text" name="email" id="name" placeholder="Email" required/>
  <?php } ?>
  <label id="icon" for="name"><i class="icon-user"></i></label>
  <input type="text" name="name" id="name" placeholder="Name" required/>
  <label id="icon" for="password"><i class="icon-shield"></i></label>
  <input type="password" name="password" id="name" placeholder="Password" required/>
  
  <label id="icon" for="company"><i class="icon-home"></i></label>
  <?php if($record != null) { foreach ($record as $row){ ?>
  <input style="margin-top: -3px;" type="text" name="company" id="name" placeholder="Company" readonly value="<?php echo $row->company ?>"/>
  <?php } } else { ?>
  <input style="margin-top: -3px;" type="text" name="company" id="name" placeholder="Company" required/>
  <?php } ?>
  <br><br>
  <div class="gender">
    <input type="radio" value="male" id="male" name="gender" checked/>
    <label for="male" class="radio" chec>Male</label>
    <input type="radio" value="female" id="female" name="gender" />
    <label for="female" class="radio">Female</label>
   </div> 
   <p>By clicking Register, you agree on our terms and condition.</p>
   <?php if($record != null) { foreach ($record as $row){ ?>
   <input type="hidden" name="user_id" value="<?php echo $row->id ?>">
   <?php } } else { ?>
   <input type="hidden" name="user_id" value="new">
   <?php } ?>
   <input type="submit" name="submit" value="Register">
  </form>
</div>
</div>    
    </body>
</html>