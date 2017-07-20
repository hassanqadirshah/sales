<?php

class itemsale_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function show_record($company, $start_from) {
        $sql = "SELECT invoices_details.id AS sale_id, invoices_details.item_id, invoices_details.qty, invoices_details.discounted_price,
            invoices.shop_id, invoices.sale_date, invoices.company, invoices.invoice,
            items.* , shops.shop_name ,shops.discount , shops.id AS shop_id FROM invoices_details INNER JOIN 
            invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = items.id 
            INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices.company = '$company' 
                ORDER BY shops.shop_name LIMIT $start_from,10";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_record($id) {
        $sql = "SELECT invoices_details.id AS sale_id, invoices_details.item_id, invoices_details.qty, invoices_details.discounted_price,
            invoices.shop_id, invoices.sale_date, invoices.company, invoices.invoice,
            items.* , shops.shop_name ,shops.discount , shops.id AS shop_id FROM invoices_details INNER JOIN 
            invoices ON invoices_details.itemSaleDetailId = invoices.id INNER JOIN items ON invoices_details.item_id = items.id 
            INNER JOIN shops ON invoices.shop_id = shops.id WHERE invoices_details.id = '$id'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function num_record($company) {
        $sql = "SELECT invoices_details.*, invoices.* FROM invoices_details INNER JOIN 
            invoices ON invoices_details.itemSaleDetailId = invoices.id WHERE invoices.company = '$company'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_itemsale_record($company, $shop_id) {
        $sql = "SELECT * FROM invoices INNER JOIN invoices_details ON invoices.id = 
            invoices_details.itemSaleDetailId WHERE invoices.company = '$company' AND (invoices.shop_id = '$shop_id')";
        $query = $this->db->query($sql)->result();
//        echo '<pre>';
//        print_r($query);
//        exit;
        return $query;
    }

    function get_itemsale_record_invoice($company, $invoice) {
        $sql = "SELECT invoices.* , invoices_details.* FROM invoices_details INNER JOIN invoices 
            ON invoices_details.itemSaleDetailId = invoices.id WHERE invoices.company = '$company' 
                AND invoices.invoice = '$invoice'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function getitem($item_id) {
        $sql = "SELECT * FROM items WHERE id = '$item_id'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function delete_sale_record($invoice, $company, $rowId) {
        $this->db->where('invoice', $invoice);
        $this->db->where('company', $company);
        $this->db->delete('invoices');

        $this->db->where('itemSaleDetailId', $rowId);
        $this->db->delete('invoices_details');
    }

    function get_discount_price($shop_id) {
        $sql = "SELECT amount FROM payment WHERE shop_id = '$shop_id' AND is_received = 'received'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_amount($shop_id) {
        $sql = "SELECT discounted_price,invoices.* FROM invoices_details INNER JOIN invoices ON 
            invoices_details.itemSaleDetailId = invoices.id  WHERE invoices.shop_id = '$shop_id'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function add_payment($data) {
        $this->db->insert('payment', $data);
        return;
    }

    function get_payment($shop_id) {
        $sql = "SELECT * FROM payment WHERE shop_id = '$shop_id'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function delete_payment($payment_id) {
        $this->db->where('id', $payment_id);
        $this->db->delete('payment');
    }

    function update_payment($payment_id, $data) {
        $this->db->where('id', $payment_id);
        $this->db->update('payment', $data);
    }

    function payment_records($shop_id = null) {
        if ($shop_id != null) {
            $this->db->select('*');
            $this->db->where('shop_id', $shop_id);
            $this->db->where('is_received', '0');
            $this->db->from('payment');
            $query = $this->db->get();
        } else {
            $this->db->select('*');
            $this->db->where('is_received', '0');
            $this->db->from('payment');
            $query = $this->db->get();
        }
        return $query->result();
    }

    function payment_record($payment_id) {
        $this->db->select('*');
        $this->db->where('id', $payment_id);
        $this->db->from('payment');
        $query = $this->db->get();
        return $query->result();
    }

    function get_payment_id($payment_id) {
        $sql = "SELECT * FROM payment WHERE id = '$payment_id'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function getshop_id($payment_id) {
        $sql = "SELECT * FROM payment WHERE id = '$payment_id'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

}