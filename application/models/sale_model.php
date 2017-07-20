<?php

class Sale_model extends CI_Model {

    function get_record($company) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.shop_name, shops.discount, shops.id AS 
            shop_id  FROM invoices_details INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id
            INNER JOIN items on invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = 
            shops.id WHERE invoices.company = '{$company}'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_item_record($item_id) {
        $query = $this->db->get_where('items', array('id' => $item_id));
        return $query->result();
    }

    function get_shop_record($shop_id) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.shop_name, shops.discount, shops.id AS 
            shop_id  FROM invoices_details INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id
            INNER JOIN items on invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = 
            shops.id WHERE shops.id = '{$shop_id}'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_record_date($date) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.shop_name, shops.discount, shops.id AS 
            shop_id  FROM invoices_details INNER JOIN invoices ON invoices_details.itemSaleDetailId = invoices.id
            INNER JOIN items on invoices_details.item_id = items.id INNER JOIN shops ON invoices.shop_id = 
            shops.id WHERE invoices.sale_date = '{$date}'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

//    function getAllRecord() {
//        $sql = "SELECT invoices.id AS invoiceID,invoices.shop_id,invoices.sale_date,invoices.company,invoices.invoice,
//            invoices_details.* FROM invoices INNER JOIN invoices_details ON invoices_details.invoice = invoices.invoice";
//        $query = $this->db->query($sql)->result();
//        return $query;
//    }
//
//    function updateAllRecord($data, $invoice) {
//        $this->db->where('invoice', $invoice);
//        $this->db->update('invoices_details', $data);
//    }

}