<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Shop Sale Report</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>css/jquery.dataTables.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo base_url() ?>css/shop-item.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url('js/jquerynew.js') ?>"></script>
        <script src="<?php echo base_url('js/jquery-ui.js') ?>"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" async="" src="https://apis.google.com/js/platform.js" gapi_processed="true"></script>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

        <script>
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: "yy-mm-dd"
                });
                $("#datepicker1").datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });
        </script>
        <!--        <script src="<?php echo base_url() ?>js/script.js"></script>-->
        <script src="<?php echo base_url() ?>js/my_js.js"></script>


    </head>

    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!--                 Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url() ?>/sales">Sales Application</a>
                </div>
                <!--                 Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Items</a>
                            <ul class="dropdown-menu">
<!--                                <li><a href='<?php echo site_url() ?>/addItem'>Add Items</a>
                                </li>-->
                                <li><a href='<?php echo site_url() ?>/addItem/show_item'>Item Details</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Customers</a>
                            <ul class="dropdown-menu">
<!--                                <li><a href='<?php echo site_url() ?>/addShop'>Add Shop</a>
                                </li>-->
                                <li><a href='<?php echo site_url() ?>/addShop/show_shop'>Customer Details</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Invoice</a>
                            <ul class="dropdown-menu">
                                <li><a href='<?php echo site_url() ?>/item_sales'>Add Sale Invoice</a>
                                </li>
<!--                                <li><a href='<?php echo site_url() ?>/item_sales/sales_details'>Sales Details</a>
                                </li>-->
                                <li><a href='<?php echo site_url() ?>/item_sales/sales_invoice_edit'>Edit Sale Invoice</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/item_sales/add_payment_invoice'>Add Payment Invoice</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/item_sales/payment_invoice_edit'>Edit Payment Invoice</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/item_sales/unpaid_payments'>Unpaid Payments</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Report</a>
                            <ul class="dropdown-menu">
                                <li><a href='<?php echo site_url() ?>/report'>Show Report</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/report/detail_report'>Detail Report</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/report/shop_report'>Customer Report</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/report/sales_report'>Sales Report</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/report/shop_sale_report'>Customer Sales Report</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/report/overdue_report'>Overdue Checks Report</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/report/payment_report'>Payment Report</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Raw Item</a>
                            <ul class="dropdown-menu">
                                <li><a href='<?php echo site_url() ?>/material'>Item Details</a>
                                </li>
<!--                                <li><a href='<?php echo site_url() ?>/material/add_material'>Add Material Name</a>
                                </li>-->
                                <li><a href='<?php echo site_url() ?>/material/material_purchase'>Purchase Item</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/material/material_purchase_edit'>Purchase Item Edit</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/material/material_release'>Release Item</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/material/material_release_edit'>Release Item Edit</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Item Report</a>
                            <ul class="dropdown-menu">
                                <li><a href='<?php echo site_url() ?>/material/purchase_report'>Purchasing Report</a>
                                </li>
                                <li><a href='<?php echo site_url() ?>/material/release_report'>Releasing Report</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?php echo site_url() ?>/admin">Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url() ?>/login/logout">Logout</a>
                        </li>
                    </ul>
                </div>
                <!--                 /.navbar-collapse -->
            </div>
            <!--             /.container -->
        </nav>