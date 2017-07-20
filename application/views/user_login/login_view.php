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
    <body>
        <div class="login">
            <span href="#" class="button" id="toggle-login">Log in</span>

            <div id="login">
                <div id="triangle"></div>
                <h1>Log in</h1>
                <form action="<?php echo site_url() ?>/login/login_validation" method="post">
                    <input type="email" name="email" placeholder="Email" />
                    <input type="password" name="password" placeholder="Password" />
                    <input type="submit" value="Log in" />
                </form>
                <p class="create-acc"><a href="<?php echo site_url() ?>/login/signup">Create Account</a></p>
            </div>
            
        </div>
    </body>
</html>
