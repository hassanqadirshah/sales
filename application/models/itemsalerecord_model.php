<?php

class itemsalerecord_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add_sale_record($data) {
        $this->db->insert('invoices_details', $data);
        return;
    }

    function delete_record($id) {
        $this->db->where('id', $id);
        $this->db->delete('invoices_details');
    }

    function getID($id) {
        $sql = "SELECT itemSaleDetailId FROM invoices_details WHERE id = '$id'";
        $query = $this->db->query($sql)->result();
        return $query;
    }
    
    function countRows($itemSaleDetailId)
    {
        $sql = "SELECT COUNT(itemSaleDetailId) AS rows FROM invoices_details WHERE itemSaleDetailId = '$itemSaleDetailId'";
        $query = $this->db->query($sql)->result();
        return $query;
    }
    
    function delete_invoice_record($id, $itemSaleDetailId)
    {
        $this->db->where('id', $id);
        $this->db->delete('invoices_details');
        
        $this->db->where('id', $itemSaleDetailId);
        $this->db->delete('invoices');
    }

}