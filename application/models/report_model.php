<?php

class Report_model extends CI_Model {

    function show_record($company) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.* FROM invoices_details
            INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON 
            invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE 
            invoices.company = '$company' ORDER BY invoices.sale_date,shops.shop_name";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_record_date($fromdate, $todate, $shop, $item, $id) {
        if ($fromdate != NULL && $todate != NULL) {
            $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.* FROM invoices_details
            INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items 
            ON invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE 
            invoices.sale_date >= '{$fromdate}' AND (invoices.sale_date <= '{$todate}') AND 
            (invoices.user_id = '$id')";
        } elseif ($fromdate != NULL && $todate == NULL) {
            $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.* FROM invoices_details
            INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items 
            ON invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE 
            invoices.sale_date >= '{$fromdate}' AND (invoices.user_id = '$id')";
        } elseif ($fromdate == NULL && $todate != NULL) {
            $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.* FROM invoices_details
            INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items 
            ON invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE 
            (invoices.sale_date <= '{$todate}') AND (invoices.user_id = '$id')";
        } else {
            $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.* FROM invoices_details
            INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items 
            ON invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE 
            invoices.user_id = '$id' ";
        }
        if ($shop != "") {
            $sql = $sql . "AND (shops.shop_name = '{$shop}')";
        }
        if ($item != "") {
            $sql = $sql . "AND (items.item_name = '{$item}')";
        }
        $sql = $sql . "ORDER BY shops.shop_name,invoices.sale_date";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_shop_record($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("shop_name");
        $this->db->from('shops');
        $query = $this->db->get();
        return $query->result();
    }

    function show_item_record($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("item_name");
        $this->db->from('items');
        $query = $this->db->get();
        return $query->result();
    }

//    function num_record($company) {
//        $sql = "SELECT item_sale.id AS sale_id, item_sale.user_id, item_sale.item_id,item_sale.shop_id,item_sale.sale_date,item_sale.qty, 
//            item_sale.discounted_price,item_sale.company, items.* , shops.shop_name ,shops.discount , shops.id AS shop_id  from item_sale 
//            INNER JOIN items ON item_sale.item_id = items.id INNER JOIN shops ON item_sale.shop_id = shops.id
//            WHERE item_sale.company = '$company'";
//        $query = $this->db->query($sql);
//        return $query->num_rows();
//    }

    function show_price_record($company) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.* FROM invoices_details
            INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items 
            ON invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE 
            invoices.company = '$company'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_detail_record($company) {
        $sql = "SELECT invoices_details.*, invoices.*,items.* , shops.shop_name ,shops.discount , 
            shops.id AS shop_id  FROM invoices_details INNER JOIN invoices ON invoices_details.itemSaleDetailId 
            = invoices.id INNER JOIN items ON invoices_details.item_id = items.id INNER JOIN shops ON 
            invoices.shop_id = shops.id WHERE invoices.company = '$company' GROUP BY shops.shop_name";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function getshop_data($company, $shop) {
        $sql = "SELECT invoices_details.item_id, SUM(invoices_details.qty) as qty, invoices_details.discounted_price, invoices_details.itemSaleDetailId,
            invoices.*,items.* , shops.shop_name ,shops.discount , shops.id AS shop_id  FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = items.id INNER JOIN shops ON 
            invoices.shop_id = shops.id WHERE invoices.company = '$company' AND (shops.shop_name = '$shop') GROUP BY items.item_name 
                ORDER BY shops.shop_name";

        $query = $this->db->query($sql)->result();
//        echo '<pre>';
//        print_r($query);
//        exit;
        return $query;
    }

    function get_detail_record_date($shop, $company) {
        $sql = "SELECT invoices_details.*, invoices.*,items.* , shops.shop_name ,shops.discount , 
            shops.id AS shop_id FROM invoices_details INNER JOIN invoices ON invoices_details.itemSaleDetailId 
            = invoices.id INNER JOIN items ON invoices_details.item_id = items.id INNER JOIN shops ON 
            invoices.shop_id = shops.id WHERE invoices.company = '$company' AND (shops.shop_name = '$shop')
                GROUP BY shops.shop_name";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_shop_report($shop, $company, $fromdate, $todate) {
        if ($shop != null) {
            $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice, invoices.specialDiscount, items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = 
            items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' 
                AND (shops.shop_name = '$shop') GROUP BY invoices_details.item_id";
        }
        if ($shop != null && $fromdate != NULL && $todate != NULL) {
            $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice, invoices.specialDiscount, items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = items.id 
            INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' AND 
            (shops.shop_name = '$shop') AND (invoices.sale_date >= '{$fromdate}')  AND (invoices.sale_date <= '{$todate}') 
            GROUP BY invoices_details.item_id";
        }
        if ($shop != null && $fromdate != NULL && $todate == NULL) {
            $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice, invoices.specialDiscount, items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = 
            items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' 
            AND (shops.shop_name = '$shop') AND (invoices.sale_date >= '{$fromdate}') GROUP BY 
            invoices_details.item_id";
        }
        if ($shop != null && $fromdate == NULL && $todate != NULL) {
            $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice, invoices.specialDiscount, items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = items.id 
            INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' AND 
            (shops.shop_name = '$shop') AND (invoices.sale_date <= '{$todate}') GROUP BY invoices_details.item_id";
        }
        if ($shop == null && $fromdate != NULL && $todate != NULL) {
            $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice, invoices.specialDiscount, items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = 
            items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' 
            AND (invoices.sale_date >= '{$fromdate}') AND (invoices.sale_date <= '{$todate}') GROUP BY 
            invoices_details.item_id,shops.shop_name ORDER BY invoices.shop_id";
        }
        if ($shop == null && $fromdate != NULL && $todate == NULL) {
            $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice, invoices.specialDiscount, items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = 
            items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' 
            AND (invoices.sale_date >= '{$fromdate}') GROUP BY invoices_details.item_id,shops.shop_name 
            ORDER BY invoices.shop_id";
        }
        if ($shop == null && $fromdate == NULL && $todate != NULL) {
            $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice, invoices.specialDiscount, items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = items.id 
            INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' 
            AND (invoices.sale_date <= '{$todate}') GROUP BY invoices_details.item_id,shops.shop_name ORDER 
            BY invoices.shop_id";
        }

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function payment_report_filter($shop, $company, $fromdate, $todate) {
        if ($shop != null) {
            $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND payment.shop_id = $shop AND payment.is_received = 'received'
            ORDER BY payment.date";
        }
        if ($shop != null && $fromdate != NULL && $todate != NULL) {
            $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND payment.shop_id = $shop
            AND (payment.date >= '{$fromdate}')  AND (payment.date <= '{$todate}') AND payment.is_received = 'received'
            ORDER BY payment.date";
        }
        if ($shop != null && $fromdate != NULL && $todate == NULL) {
            $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND payment.shop_id = $shop
            AND (payment.date >= '{$fromdate}') AND payment.is_received = 'received' ORDER BY payment.date";
        }
        if ($shop != null && $fromdate == NULL && $todate != NULL) {
            $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND payment.shop_id = $shop
            AND (payment.date <= '{$todate}') AND payment.is_received = 'received' ORDER BY payment.date";
        }
        if ($shop == null && $fromdate != NULL && $todate != NULL) {
            $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND (payment.date >= '{$fromdate}')
            AND (payment.date <= '{$todate}') AND payment.is_received = 'received' ORDER BY payment.date";
        }
        if ($shop == null && $fromdate != NULL && $todate == NULL) {
            $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND (payment.date >= '{$fromdate}') 
            AND payment.is_received = 'received' ORDER BY payment.date";
        }
        if ($shop == null && $fromdate == NULL && $todate != NULL) {
            $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND (payment.date <= '{$todate}')
                AND payment.is_received = 'received' ORDER BY payment.date";
        }

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_shop_report_pageload($company) {
        $sql = "SELECT invoices_details.id, invoices_details.item_id, SUM(invoices_details.qty) as qty, 
            SUM(invoices_details.discounted_price) as discounted_price, invoices.shop_id, invoices.sale_date,
            invoices.invoice,items.* , shops.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = 
            items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' 
            GROUP BY invoices_details.item_id";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_payment_detail($company) {
        $sql = "SELECT shops.*, payment.* FROM payment INNER JOIN shops ON 
            payment.shop_id = shops.id WHERE payment.company = '$company' AND payment.is_received = 'received'
            ORDER BY payment.date";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_payment_report($shop) {
        $sql = "SELECT * FROM payment WHERE shop_id = '$shop' AND is_received = 'received'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_shopid($shop) {
        $sql = "SELECT * FROM shops WHERE shop_name = '$shop'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_overall_report($company) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.shop_name ,
            shops.discount , shops.id AS shop_id FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = 
            items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company 
            = '$company'";

        $query = $this->db->query($sql)->result();


        return $query;
    }

    function getspecialDiscount($company) {
        $sql = "SELECT SUM(invoices.specialDiscount) as specialDiscount FROM invoices 
        WHERE invoices.company = '$company'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function getshopspecialDiscount($company, $shop) {
        $sql = "SELECT SUM(invoices.specialDiscount) as specialDiscount FROM invoices 
        WHERE invoices.company = '$company' AND (invoices.shop_id = '$shop')";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_overall_payment($company) {
        $sql = "SELECT * FROM payment WHERE company = '$company'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_overall_report_shop($company, $shop_id) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.shop_name ,
            shops.discount , shops.id AS shop_id FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = 
            items.id INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company 
            = '$company' AND (shop_id = '$shop_id')";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_overall_payment_shop($company, $shop_id) {
        $sql = "SELECT * FROM payment WHERE company = '$company' AND (shop_id = '$shop_id')";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function payment_shop_filter($company, $shop_id, $fromdate, $todate) {
        $whr = "";
        if ($shop_id != null && $fromdate != null && $todate != null) {
            $whr = " AND (payment.shop_id = '$shop_id') AND (payment.date >= '$fromdate') AND payment.date <= '$todate'";
        } else if ($shop_id != null && $fromdate == null && $todate == null) {
            $whr = " AND (payment.shop_id = '$shop_id')";
        } else if ($shop_id == null && $fromdate != null && $todate == null) {
            $whr = " AND (payment.date >= '$fromdate')";
        } else if ($shop_id == null && $fromdate == null && $todate != null) {
            $whr = " AND payment.date <= '$todate'";
        } elseif ($shop_id != null && $fromdate != null && $todate == null) {
            $whr = " AND (payment.shop_id = '$shop_id') AND (payment.date >= '$fromdate')";
        } elseif ($shop_id != null && $fromdate == null && $todate != null) {
            $whr = " AND (payment.shop_id = '$shop_id') AND payment.date <= '$todate'";
        } elseif ($shop_id == null && $fromdate != null && $todate != null) {
            $whr = " AND (payment.date >= '$fromdate') AND payment.date <= '$todate'";
        }
        $sql = "SELECT * FROM payment WHERE payment.company = '$company' ". $whr;
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_overdue_checks($company, $date) {
        $sql = "SELECT payment.*, shops.* FROM payment INNER JOIN shops ON payment.shop_id = shops.id
            WHERE payment.company = '$company' AND (payment.overdue_date <= '$date') AND (payment.overdue_date != '0000-00-00')
                AND (is_received = '0') ORDER BY payment.overdue_date DESC";
//        echo $sql;
//        exit;
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_shop_sale_record($shop, $company) {
        $sql = "SELECT invoices.invoice, shops.shop_name, invoices.`specialDiscount`, SUM(invoices_details.discounted_price)
            AS applied_discount, SUM(invoices_details.discounted_price)-invoices.`specialDiscount` AS discounted_price,
            SUM(invoices_details.qty) AS total_qty FROM `invoices` INNER JOIN shops ON shops.id=invoices.shop_id LEFT JOIN invoices_details
            on invoices.id=invoices_details.itemSaleDetailId WHERE shop_id=$shop AND invoices.company = '$company' GROUP BY 
                invoices_details.itemSaleDetailId order by invoices.invoice+0";

        $query = $this->db->query($sql)->result();
        return $query;
    }

}